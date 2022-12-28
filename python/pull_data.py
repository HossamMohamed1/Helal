import re
import json
import uvicorn
import matplotlib
import pandas as pd
import urllib.request
import numpy as np
import traceback

from io import BytesIO
from datetime import date
from fastapi import FastAPI, Request
from scipy.optimize import fmin_slsqp
from statistics import mean


class DEA(object):

    def __init__(self, inputs, outputs, names):
        """
        Initialize the DEA object with input data
        n = number of entities (observations)
        m = number of inputs (variables, features)
        r = number of outputs
        :param inputs: inputs, n x m numpy array
        :param outputs: outputs, n x r numpy array
        :return: self
        """

        # supplied data
        self.inputs = inputs
        self.outputs = outputs

        # parameters
        self.n = inputs.shape[0]
        self.m = inputs.shape[1]
        self.r = outputs.shape[1]

        # iterators
        self.unit_ = range(self.n)
        self.input_ = range(self.m)
        self.output_ = range(self.r)

        # result arrays
        self.output_w = np.zeros(
            (self.r, 1), dtype=np.float64)  # output weights
        self.input_w = np.zeros((self.m, 1), dtype=np.float64)  # input weights
        self.lambdas = np.zeros(
            (self.n, 1), dtype=np.float64)  # unit efficiencies
        self.efficiency = np.zeros_like(self.lambdas)  # thetas
        # names
        self.names = []
        self.name_units(names)

    def __efficiency(self, unit):
        """
        Efficiency function with already computed weights
        :param unit: which unit to compute for
        :return: efficiency
        """

        # compute efficiency
        denominator = np.dot(self.inputs, self.input_w)
        numerator = np.dot(self.outputs, self.output_w)

        return (numerator/denominator)[unit]

    def __target(self, x, unit):
        """
        Theta target function for one unit
        :param x: combined weights
        :param unit: which production unit to compute
        :return: theta
        """
        in_w, out_w, lambdas = x[:self.m], x[self.m:(
            self.m+self.r)], x[(self.m+self.r):]  # unroll the weights
        denominator = np.dot(self.inputs[unit], in_w)
        numerator = np.dot(self.outputs[unit], out_w)

        return numerator/denominator

    def __constraints(self, x, unit):
        """
        Constraints for optimization for one unit
        :param x: combined weights
        :param unit: which production unit to compute
        :return: array of constraints
        """

        in_w, out_w, lambdas = x[:self.m], x[self.m:(
            self.m+self.r)], x[(self.m+self.r):]  # unroll the weights
        constr = []  # init the constraint array

        # for each input, lambdas with inputs
        for input in self.input_:
            t = self.__target(x, unit)
            lhs = np.dot(self.inputs[:, input], lambdas)
            cons = t*self.inputs[unit, input] - lhs
            constr.append(cons)

        # for each output, lambdas with outputs
        for output in self.output_:
            lhs = np.dot(self.outputs[:, output], lambdas)
            cons = lhs - self.outputs[unit, output]
            constr.append(cons)

        # for each unit
        for u in self.unit_:
            constr.append(lambdas[u])

        return np.array(constr)

    def __optimize(self):
        """
        Optimization of the DEA model
        Use: http://docs.scipy.org/doc/scipy-0.17.0/reference/generated/scipy.optimize.linprog.html
        A = coefficients in the constraints
        b = rhs of constraints
        c = coefficients of the target function
        :return:
        """
        d0 = self.m + self.r + self.n
        # iterate over units
        for unit in self.unit_:
            # weights
            x0 = np.random.rand(d0) - 0.5
            x0 = fmin_slsqp(self.__target, x0,
                            f_ieqcons=self.__constraints, args=(unit,))
            # unroll weights
            self.input_w, self.output_w, self.lambdas = x0[:self.m], x0[self.m:(
                self.m+self.r)], x0[(self.m+self.r):]
            self.efficiency[unit] = self.__efficiency(unit)

    def name_units(self, names):
        """
        Provide names for units for presentation purposes
        :param names: a list of names, equal in length to the number of units
        :return: nothing
        """

        assert(self.n == len(names))

        self.names = names

    def fit(self):
        """
        Optimize the dataset, generate basic table
        :return: table
        """

        while True:

            self.__init__(self.inputs, self.outputs, self.names)
            self.__optimize()  # optimize

            if len([wi for wi in self.input_w if wi >= 0.0]) == len(self.input_w):
                if len([wi for wi in self.output_w if wi >= 0.0]) == len(self.output_w):
                    break


class NetworkGraph():

    def __init__(self) -> None:
        self.series = {'series': {'edges': [], 'nodes': []}}

    def get_nodes(self, df):

        nodes = []
        nodes_feats = []
        node_to_indx = {}
        nodes_col = {}

        for i in range(1, len(df)):

            row = df[i]

            if row[0] == None:
                continue

            row[0] = f"{row[0]}".strip()

            colorB = ''

            if type(row[4]) == type(" "):

                colorA = row[4].lower().replace(' ', '')
                colorB = colorA

                if colorA not in matplotlib.colors.cnames:

                    colorB = row[4].lower().split()
                    colorB = colorB[::-1]
                    colorB = "".join(colorB)

                nodes_col[i-1] = colorB

            else:
                colorB = ''

            nodes.append(row[0])
            node_to_indx[row[0]] = i-1

            nodes_feats.append({
                "organization": row[0],
                "shape": f"{row[1]}".lower(),
                "tier": int(row[2]),
                "size": int(row[3]),
                "color": colorB
            })

        return nodes, node_to_indx, nodes_col, nodes_feats

    def get_edges(self, df):

        edges = []

        for i in range(1, len(df)):

            row = df[i]

            if row[0] == None or row[1] == None:
                continue

            u, v = row[0].strip(), row[1].strip()

            dir = row[2].strip().lower()

            if dir == 'both':

                edges.append({
                    'from': u,
                    'to': v,
                    "color": row[3].lower(),
                    "strength": int(row[4]),
                    "direction": dir,
                    "description": row[5]
                })

                edges.append({
                    'from': v,
                    'to': u,
                    "color": row[3].lower(),
                    "strength": int(row[4]),
                    "direction": dir,
                    "description": row[5]
                })

            elif dir == 'in':

                edges.append({
                    'from': u,
                    'to': v,
                    "color": row[3].lower(),
                    "strength": int(row[4]),
                    "direction": dir,
                    "description": row[5]
                })

            else:

                edges.append({
                    'from': v,
                    'to': u,
                    "color": row[3].lower(),
                    "strength": int(row[4]),
                    "direction": dir,
                    "description": row[5]
                })

        return edges

    def get_graphs(self, jsons):

        nodes_data, edges_data = jsons[1], jsons[2]

        nodes, node_to_indx, nodes_col, nodes_feats = self.get_nodes(
            nodes_data)

        edges = self.get_edges(edges_data)

        rest_nodes = []

        for node in nodes:

            info_node = {'label': node}
            indx = node_to_indx[node]
            size = nodes_feats[indx]['size']*10
            borderWidthSelected = nodes_feats[indx]['size']*4

            info_node['tier'] = nodes_feats[indx]['tier']
            info_node['size'] = size
            info_node['value'] = size
            info_node['shape'] = f"{'dot' if nodes_feats[indx]['shape']=='circle' else 'square'}"
            info_node['borderWidthSelected'] = borderWidthSelected
            info_node['labelHighlightBold'] = True
            info_node['physics'] = True
            info_node['title'] = "\n".join(
                [f"{key.capitalize()}: {value}" for key, value in nodes_feats[indx].items()])
            info_node['id'] = indx

            colorB = None

            if indx in nodes_col:
                colorB = nodes_col[indx]

            else:

                for edge in edges:

                    u, v = edge['from'], edge['to']

                    indxu, indxv = node_to_indx[u], node_to_indx[v]

                    if indxu != indx and indxv != indx:
                        continue

                    if indxu in nodes_col:
                        colorB = nodes_col[indxu]

                    elif indxv in nodes_col:
                        colorB = nodes_col[indxv]

            if colorB != None:

                info_node['color'] = colorB
                nodes_col[indx] = colorB
                self.series['series']['nodes'].append(info_node)

            else:
                rest_nodes.append(node)

        for node in rest_nodes:

            indx = node_to_indx[node]

            info_node = {'label': node}
            size = nodes_feats[indx]['size']*10
            borderWidthSelected = nodes_feats[indx]['size']*4

            info_node['size'] = size
            info_node['value'] = size
            info_node['shape'] = f"{'dot' if nodes_feats[indx]['shape']=='circle' else 'square'}"
            info_node['borderWidthSelected'] = borderWidthSelected
            info_node['labelHighlightBold'] = True
            info_node['physics'] = True
            info_node['title'] = "\n".join(
                [f"{key.capitalize()}: {value}" for key, value in nodes_feats[indx].items()])
            info_node['id'] = indx

            colorB = '#38445e'

            if indx in nodes_col:
                colorB = nodes_col[indx]

            else:

                for edge in edges:

                    u, v = edge['from'], edge['to']
                    indxu, indxv = node_to_indx[u], node_to_indx[v]

                    if indxu != indx and indxv != indx:
                        continue

                    if indxu in nodes_col:
                        colorB = nodes_col[indxu]

                    elif indxv in nodes_col:
                        colorB = nodes_col[indxv]

            info_node['color'] = colorB
            self.series['series']['nodes'].append(info_node)

        # Using Compulative sum ....
        com_nodes = [[0]*10 for _ in nodes]

        for edge in edges:

            u, v = edge['from'], edge['to']
            indxu, indxv = node_to_indx[u], node_to_indx[v]

            com_nodes[indxu][nodes_feats[indxv]['tier']] = 100
            com_nodes[indxv][nodes_feats[indxu]['tier']] = 100

        for i in range(len(nodes)):

            temp = com_nodes[i]

            for j in range(1, len(temp)):
                temp[j] += temp[j-1]

            com_nodes[i] = temp

        for edge in edges:

            colorA = edge['color'].replace(' ', '')
            colorB = colorA

            if colorA not in matplotlib.colors.cnames:

                colorB = edge['color'].split()
                colorB = colorB[::-1]
                colorB = "".join(colorB)

            indxu = node_to_indx[edge['from']]
            indxv = node_to_indx[edge['to']]

            leng = com_nodes[indxu][nodes_feats[indxv]['tier']]
            leng = max(com_nodes[indxv][nodes_feats[indxu]['tier']], leng)

            title = f'''
            Direction: {edge['direction'].capitalize()}
            Color: {colorB}
            Strength: {edge['strength']}
            Connection-Length:{leng}
            Description: {edge['description']}
            '''

            self.series['series']['edges'].append({

                'arrows': 'to' if edge['direction'] == 'in' else 'from',
                'from': indxu,
                'to': indxv,
                'label': int(edge['strength']),
                'physics': True,
                'title': title,
                'length': leng,
                'width': int(edge['strength'])/2
            })

        # with open("series.json", "w") as write_file:
        #     json.dump(self.series, write_file, indent=2)

        return self.series


class Pie():

    def __init__(self) -> None:
        self.series = {'series': []}

    def get_values(self, dataJson):

        for i in range(1, len(dataJson)):

            v = 0.0

            try:
                v = float(f"{dataJson[i][1]}".strip())

            except:
                pass

            self.series['series'].append(
                {'name': f"{dataJson[i][0]}".strip(), 'value': v})

        return self.series


class Bar():

    def __init__(self) -> None:
        self.series = {'series': []}

    def get_values(self, dataJson):

        try:

            for i in range(1, len(dataJson[0])):

                category = dataJson[0][i]
                category = f"{category}".strip()

                catDict = {'category': category}

                for j in range(1, len(dataJson)):

                    name = dataJson[j][0]

                    if name == None:
                        continue

                    name = f"{dataJson[j][0]}".strip()

                    v = 0.0

                    try:
                        v = float(f"{dataJson[j][i]}".strip())

                    except:
                        pass

                    catDict[name] = v

                self.series['series'].append(catDict)

        except Exception as ex:
            print(f"[ERROR] {ex}")

        return self.series


class Line():

    def __init__(self) -> None:

        self.series = {'series': {'line': []}}

    def get_values(self, dataJson, inputs, outputs):

        today = date.today()
        thisDay = today.strftime("%Y-%m-%d")

        try:

            weights = {}
            weighted_data = {}

            inps_name = [f"{dataJson[0][int(j)]}".strip() for j in inputs]
            outs_name = [f"{dataJson[0][int(j)]}".strip() for j in outputs]

            data = None

            dates = []
            indxDate = None

            for i in range(len(dataJson[0])):
                if f"{dataJson[0][i]}".lower() == 'date':
                    for j in range(1, len(dataJson)):
                        dates.append(f"{dataJson[j][i]}".strip())

                    indxDate = i

            if indxDate == None:

                indxDate = len(dataJson[0])
                dataJson[0].append('date')

                for i in range(1, len(dataJson)):
                    dataJson[i].append(thisDay)

                dates.append(thisDay)

            dates = list(set(dates))

            all_effs = {}

            for datei in dates:

                indxsDate = [i for i in range(
                    1, len(dataJson)) if f"{dataJson[i][indxDate]}".strip() == datei]

                names, inps, outs = [], [], []

                # [Clear Data]
                data = {f"I({dataJson[0][int(j)]})".strip(): []
                        for j in inputs}
                data.update(
                    {f"O({dataJson[0][int(j)]})".strip(): [] for j in outputs})

                for i in indxsDate:

                    names.append(f"{dataJson[i][0]}".strip())
                    vs = []

                    for j in inputs:

                        v = 0.0
                        try:
                            v = float(f"{dataJson[i][int(j)]}".strip())

                        except:
                            pass

                        vs.append(v)

                        data[f"I({dataJson[0][int(j)]})".strip()
                             ].append(float(v))

                    inps.append(vs)

                    vs = []

                    for j in outputs:

                        v = 0.0
                        try:
                            v = float(f"{dataJson[i][int(j)]}".strip())

                        except:
                            pass

                        vs.append(v)
                        data[f"O({dataJson[0][int(j)]})".strip()
                             ].append(float(v))

                    outs.append(vs)

                    dea = DEA(np.array(inps), np.array(outs), names)
                    dea.fit()

                    weigthed_input = dea.input_w / sum(dea.input_w)
                    weigthed_ouput = dea.output_w / sum(dea.output_w)

                    cur_weighted = {f'I({inps_name[i]})': "{:.2f}".format(
                        weigthed_input[i]*100) for i in range(len(weigthed_input))}
                    cur_weighted.update({f'O({outs_name[i]})': "{:.2f}".format(
                        weigthed_ouput[i]*100) for i in range(len(weigthed_ouput))})

                    cur_weightes = {f'I({inps_name[i]})': "{:.2f}".format(
                        dea.input_w[i]) for i in range(len(dea.input_w))}
                    cur_weightes.update({f'O({outs_name[i]})': "{:.2f}".format(
                        dea.output_w[i]) for i in range(len(dea.output_w))})

                    for k, v in cur_weighted.items():

                        v = float(v)

                        if k not in weighted_data:
                            weighted_data[k] = [v]
                        else:
                            weighted_data[k].append(v)

                    for k, v in cur_weightes.items():

                        v = float(v)

                        if k not in weights:
                            weights[k] = [v]
                        else:
                            weights[k].append(v)

                effs = {'date': datei}

                NO_effs, NO_ineffs = 0, 0

                for n, eff in enumerate(dea.efficiency):

                    name = dea.names[n]
                    effs[name] = "{:.2f}".format(eff[0])

                    if name in all_effs:
                        all_effs[name].append(float(effs[name]))

                    else:
                        all_effs[name] = [float(effs[name])]

                    NO_effs += bool(eff[0] >= 1)
                    NO_ineffs += bool(eff[0] < 1)

                self.series['series']['line'].append(effs)

                # Create DataFrame from data json
                DF = pd.DataFrame()

                for key, v in data.items():
                    DF[key] = v

                DF.fillna(0.0)

                description = DF.describe()
                correlation = DF.corr(method='kendall').round(2).fillna(0.0)

                description = json.loads(description.to_json())
                correlation = json.loads(correlation.to_json())

                description = [
                    {
                        'name': key,
                        'count': value['count'],
                        "mean": value['mean'],
                        "std": value['std'],
                        "min": value['min'],
                        "25%": value['25%'],
                        "50%": value['50%'],
                        "75%": value['75%'],
                        "max": value['max']
                    } for key, value in description.items()]

                correlation = [{'u': key, 'v': k, 'value': v} for key,
                               value in correlation.items() for k, v in value.items()]

                self.series['series']['summary'] = {

                    'description': description,
                    'correlation': correlation,
                    'EffsBar': [{'name': 'No. of Efficient', 'value': NO_effs}, {'name': 'No. of Inefficient', 'value': NO_ineffs}],
                }

            weighted_data = {k: float("{:.2f}".format(mean(v)))
                             for k, v in weighted_data.items()}
            weights = {k: float("{:.2f}".format(mean(v)))
                       for k, v in weights.items()}

            pareto = [(key, mean(val)*100) for key, val in all_effs.items()]
            pareto.sort(key=lambda i: i[1], reverse=True)

            self.series['series']['summary'].update(
                {'paretoRanking': [{'name': i[0], 'value':i[1]} for i in pareto]})
            self.series['series']['summary'].update({'InputWeights': [{'name': f"{key}".strip(
            ), 'value': v} for key, v in weighted_data.items() if key[0] == 'I']})
            self.series['series']['summary'].update({'OutputWeights': [{'name': f"{key}".strip(
            ), 'value': v} for key, v in weighted_data.items() if key[0] == 'O']})

            self.series['series'].update({'weights': weights})
            self.series['series'].update({'weightedData': weighted_data})

        except Exception as EX:

            EX = repr(EX)
            error = traceback.format_exc()
            line = re.findall("line \d+", error)
            line = line[0] if len(line) else ""

            EX = f"{EX} {line}"
            print(f"[ERROR] {EX}")

        return self.series


class Bubble():

    def __init__(self) -> None:
        self.series = {'series': []}

    def get_edges(self, df):

        edges = []

        for i in range(1, len(df)):

            row = df[i]

            if row[0] == None or row[1] == None:
                continue

            u, v = row[0].strip(), row[1].strip()

            dir = row[2].strip().lower()

            if dir == 'both':

                edges.append({
                    'from': u,
                    'to': v,
                    "color": row[3].lower(),
                    "strength": int(row[4]),
                    "direction": dir,
                    "description": row[5]
                })

                edges.append({
                    'from': v,
                    'to': u,
                    "color": row[3].lower(),
                    "strength": int(row[4]),
                    "direction": dir,
                    "description": row[5]
                })

            elif dir == 'in':

                edges.append({
                    'from': u,
                    'to': v,
                    "color": row[3].lower(),
                    "strength": int(row[4]),
                    "direction": dir,
                    "description": row[5]
                })

            else:

                edges.append({
                    'from': v,
                    'to': u,
                    "color": row[3].lower(),
                    "strength": int(row[4]),
                    "direction": dir,
                    "description": row[5]
                })

        return edges

    def get_values(self, dataJson):

        nodes_data, edges_data = dataJson[1], dataJson[2]

        edges = self.get_edges(edges_data)
        ID = 0
        for edge in edges:

            colorB = ''

            if type(edge['color']) == type(" "):

                colorA = edge['color'].lower().replace(' ', '')
                colorB = colorA

                if colorA not in matplotlib.colors.cnames:

                    colorB = edge['color'].lower().split()
                    colorB = colorB[::-1]
                    colorB = "".join(colorB)

            else:
                colorB = 'orange'

            info_point = {}
            info_point['id'] = f"{ID}"
            info_point['x'] = edge['from']
            info_point['y'] = edge['to']
            info_point['value'] = edge['strength']
            info_point['title'] = edge['description']
            info_point['color'] = colorB

            ID += 1

            self.series['series'].append(info_point)

        return self.series


app = FastAPI()


@app.post("/analysis")
async def analysis(request: Request):

    nGraph = NetworkGraph()
    pieChart = Pie()
    barChart = Bar()
    lineChart = Line()
    bubble = Bubble()

    req_info = await request.json()

    typeProcess = req_info['type']

    # urllib.request.url
    jsons = [json.load(urllib.request.urlopen(jsonF))
             for jsonF in req_info['files']]

    if typeProcess == 'pie':
        return pieChart.get_values(jsons[0])

    elif typeProcess == 'bar':
        return barChart.get_values(jsons[0])

    elif typeProcess == 'line':
        return lineChart.get_values(jsons[0], req_info['input'], req_info['output'])

    elif typeProcess == 'xybubble':
        return bubble.get_values(jsons)

    elif typeProcess == 'network':
        return nGraph.get_graphs(jsons)

if __name__ == '__main__':

    uvicorn.run(app,  host='127.0.0.1', port=8888)
