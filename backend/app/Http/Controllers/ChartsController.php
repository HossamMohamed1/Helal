<?php

namespace App\Http\Controllers;

use App\Http\Resources\JsonDataResource;
use App\Imports\DataImport;
use App\Models\Chart;
use App\Models\ChartFile;
use App\Models\ChartLineOutput;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charts = Chart::select(['id', 'name', 'img'])->get();
        return response()->json(['charts' => $charts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'file' => 'required',
            'data' => 'nullable',
            'config' => 'nullable',
        ]);
        $requestData = $request->only(['name', 'type', 'data', 'config', 'img']);

        // if ($request->type == 'Network' || $request->type == 'network') {
        // check for string with upper case like this
        if (strtolower($request->type) == 'network') {
            $requestData['img'] = 'network.jpg';
            // save json data will be like this
            $requestData['config'] = [
                "configure" => [
                    "enabled" => false,
                ],
                "edges" => [
                    "color" => [
                        "inherit" => true,
                    ],
                    // inherit_colors: false,
                    "smooth" => [
                        "enabled" => true,
                        "type" => "cubicBezier",
                        "roundness" => 0.3,
                    ],
                ],
                "zoom" => [
                    "direction" => "'+'/'-'",
                    "scale" => "Number",
                    "pointer" => ["x" => "pointer_x", "y" => "pointer_y"],
                ],
                "interaction" => [
                    "dragNodes" => true,
                    "hideEdgesOnDrag" => true,
                    "hideNodesOnDrag" => false,
                    "multiselect" => true,
                    "navigationButtons" => true,
                ],
                "manipulation" => false,
                "physics" => [
                    "enabled" => true,
                    "repulsion" => [
                        "centralGravity" => 0.2,
                        "damping" => 0.09,
                        "nodeDistance" => 330.0,
                        "springConstant" => 0.01848,
                        "springLength" => 200,
                    ],
                    "solver" => "repulsion",
                    "stabilization" => [
                        "enabled" => true,
                        "fit" => true,
                        "iterations" => 1000,
                        "onlyDynamicEdges" => false,
                        "updateInterval" => 50,
                    ],
                ],
                "style" => [
                    "backgroundColor" => "#ececec",
                ],
                "font" => [
                    "size" => 10,
                    "color" => "#333",
                ],
            ];

        }
        else if (strtolower($request->type) == 'pie') {
            $requestData['img'] = 'pie.jpg';
            $requestData['config'] = [
                "chart_type" => "pie",
                "title" => [
                    "name" => "",
                    "fontSize" => 21,
                    "fontWeight" => 600,
                    "align" => "center", //center or top or bottom
                    "marginBottom" => 30,
                    "fill" => "#000",
                ],
                "legend" => [
                    "disabled" => true,
                    "align" => "center",
                    "position" => "bottom", // Top or Bottom
                    "paddingBottom" => 20, // if Position is Top
                    "paddingTop" => 20, // if Position is Bottom
                ],
                "zoom" => true,
                "colors" => ["#256624", "#8b92a1", "#c0ca33", "#795548", "#546e7a", "#303f9f", "#ff5722"],
                "innerRadius" => 30,
                "stroke" => "#fff",
                "strokeWidth" => 2,
                "strokeOpacity" => 1,
                "alignLabels" => false,
                "hoverShadow" => false,
                "shadowOpacity" => 0.7,
                "style" => [
                    "backgroundColor" => "#fff",
                ],

            ];

        }
        else if (strtolower($request->type) == 'bar' || strtolower($request->type) == 'column') {
            $requestData['img'] = 'bar.jpg';
            $requestData['config'] = [
                "chart_type" => "bar",
                "zoomOutButton" => [
                    "align" => "left",
                    "valign" => "bottom",
                ],

                "title" => [
                    "name" => "", // default is chart name
                    "fontSize" => 21,
                    "fontWeight" => 600,
                    "align" => "center", //center or top or bottom
                    "marginBottom" => 30,
                    "fill" => "#000",
                ],
                "legend" => [
                    "disabled" => true,
                    "name" => "chart name",
                    "align" => "center",
                    "position" => "bottom", // Top or Bottom
                    "paddingBottom" => 20, // if Position is Top
                    "paddingTop" => 0, // if Position is Bottom
                ],
                "xLabel" => [
                    "text" => "", //Default Empty string
                    "paddingTop" => "10",
                ],
                "yLabel" => "", //Default Empty string
                "colors" => ["#256624", "#8b92a1", "#c0ca33", "#795548", "#546e7a", "#303f9f", "#ff5722"],
                "zoom" => [
                    "cursor" => "zoomXY",
                    "scrollbarX" => "true",
                    "scrollbarY" => "true",
                    "scrollbarXBottom" => "top",
                    "scrollbarYLeft" => "right",
                ],
                "labels" => [
                    "disabled" => true,
                    "fill" => "#fff",
                    "fontSize" => "17",
                    "rotation" => 0, // from 0 => 360
                    "width" => "100%", // from 1 to
                    "valign" => "bottom", // middle or top or bottom
                ],
                "Bullet" => [
                    "disabled" => true,
                    "locationY" => 0.5,
                    "fill" => "#fff",
                    "fontSize" => 17,
                    "radius" => 20,
                    "align" => "center", // center or top or bottom
                    "valign" => "middle", // middle or top or bottom

                ],
                "columnsWidth" => "40",
                "cellStartLocation" => 0.2,
                "cellEndLocation" => 0.8,
                "style" => [
                    "backgroundColor" => "#fff",
                ],
            ];

        } else if ($request->type == 'Line' || $request->type == 'line')
        {
            $requestData['img'] = 'line.jpg';
            $requestData['config'] = [
                "chart_type" => "line",
                "title" => [
                    "disabled" => true,
                    "name" => "", //default is chart name
                    "fontSize" => 21,
                    "fontWeight" => 600,
                    "align" => "center", //center or top or bottom
                    "marginBottom" => 30,
                    "fill" => "#000",
                ],
                "legend" => [
                    "disabled" => true,
                    "align" => "center",
                    "position" => "bottom", // Top or Bottom
                    "paddingBottom" => 10, // if Position is Top
                    "paddingTop" => 20, // if Position is Bottom
                ],
                "xLabel" => [
                    "text" => "", //Default Empty string
                    "paddingTop" => "10",
                ],
                "yLabel" => "", //Default Empty string
                "colors" => ["#256624", "#8b92a1", "#c0ca33", "#795548", "#546e7a", "#303f9f", "#ff5722"],
                //"zoom" => true,
                "zoom" => [
                    "cursor" => "zoomXY",
                    "scrollbarX" => "false",
                    "scrollbarY" => "false",
                    "scrollbarXBottom" => "top",
                    "scrollbarYLeft" => "right",
                ],
                "style" => [
                    "backgroundColor" => "#fff",
                ],

            ];

        } else if ($request->type == 'X Y Bubble' || $request->type == 'xybubble'){
//         else if (strtolower($request->type) == 'X Y Bubble') {
            $requestData['img'] = 'xybubble.jpg';
            $requestData['config'] = [
                "bullets" => [
                    "type" => "CircleBullet",
                    "strokeWidth" => 3,
                    "strokeOpacity" => 1,
                    "fillOpacity" => 1,
                    "fill" => "#ffffff",
                ],
                "zoom" => [
                    "cursor" => "zoomXY",
                    "scrollbarX" => "true",
                    "scrollbarY" => "true",
                    "scrollbarXBottom" => "top",
                    "scrollbarYLeft" => "right",
                ],
                "fontSize" => 5,
                "title" => [
                    "disabled" => true,
                    "text" => "", //default is chart name
                    "fontSize" => 21,
                    "fontWeight" => 600,
                    "align" => "center", //center or top or bottom
                    "marginBottom" => 20,
                    "fill" => "#000",
                ],
                "xLabel" => [
                    "text" => "", //Default Empty string
                    "marginTop" => "0",
                    "fontSize" => 17,
                    "fill" => "#000",
                ],
                "yLabel" => [
                    "text" => "",
                    "fontSize" => 17,
                    "fill" => "#000",
                    "marginRight" => "0",
                ], //Default Empty string
                "style" => [
                    "backgroundColor" => "#fff",
                ],
            ];
        }

        $chart = Chart::create($requestData);
        //REQUEST HAS FILE
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // $chart = Chart::findOrFail($request->chart_id);
            // if (!$chart) {
            //     return response()->json([
            //         'message' => 'This chart doesn\'t exists',
            //     ], 400);
            // }
            $tabs = Excel::toArray(new DataImport(), $file);
            // return file_get_contents($file);
            //  minifiset file with multiple tabs in each
            // return $tabs;

            $chart->update([
                'file_count' => count($tabs),
            ]);
            // return $tabs;
            foreach ($tabs as $key => $tab) {

                $name = $key + 1;
                $name = time() . '-part-' . $name . '.json';
                file_put_contents(public_path('excel/' . $name), collect($tab));

                ChartFile::create([
                    'file_path' => 'excel/' . $name,
                    'file_name' => basename($name),
                    'chart_id' => $chart->id,
                ]);
            }

        }
        return response()->json(['chart' => $chart, 'message' => 'Chart has been successfully created'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chart = Chart::findOrFail($id);
        return response()->json(['chart' => $chart], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $requestData = $request->only(['name', 'type', 'data', 'config', 'input_index', 'output_index']);
        $chart = Chart::findOrFail($id);
        $chart->update($requestData);
        return response()->json([
            'message' => 'Chart has been successfully updated',
            'chart' => $chart,
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Chart = Chart::findOrFail($id);
        $files = $Chart->files()->get()->pluck('file_path');
        foreach ($files as $file) {
            @unlink(public_path($file));
        }
        $Chart->files()->delete();
        $Chart->delete();
        return response()->json(['message' => 'Chart Deleted Successfully'], 200);
    }
    /**
     * Uploading File to Chart .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'chart_id' => 'required',
            'file' => 'required',
        ]);
        $file = $request->file('file');
        $chart = Chart::findOrFail($request->chart_id);
        if (!$chart) {
            return response()->json([
                'message' => 'This chart doesn\'t exists',
            ], 400);
        }
        $tabs = Excel::toArray(new DataImport(), $file);

        $chart->update([
            'file_count' => count($tabs),
        ]);
        // return $tabs;
        foreach ($tabs as $key => $tab) {

            $name = $key + 1;
            $name = time() . '-part-' . $name . '.json';
            file_put_contents(public_path('excel/' . $name), collect($tab));

            ChartFile::create([
                'file_path' => 'excel/' . $name,
                'file_name' => basename($name),
                'chart_id' => $chart->id,
            ]);
        }
        return response()->json([
            'message' => 'data has been saved successfully',
        ]);

    }

    /**
     * Uploading File to Chart .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function showFile(Request $request)
    {
        $data = file_get_contents(public_path($request->file));
        $data = json_decode($data);
        $heads = $data[0];
        // return collect($data)->limit(10);
        $data = $this->paginate(collect($data), $request->perPage ?? 10)->toArray();
        return response()->json([
            'data' => new JsonDataResource($data),
            'heads' => $heads,
        ]);

    }
    /**
     * Paginator  .
     *
     * @return \Illuminate\Http\Response
     */

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return (new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options));
    }

    /**
     * Get CHart Files .
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function chartFiles($id)
    {
        $chartFiles = ChartFile::where('chart_id', $id)->get();

        return response()->json([
            'data' => $chartFiles,
        ]);
    }
    /**
     * Analysis For Chart Data .
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function analysis($chart_id, $forStory = false)
    {

        $rows = ChartFile::where('chart_id', $chart_id)
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('file_path');
        $chart = Chart::find($chart_id);
        $post = [];
        foreach ($rows as $row) {
            $post[] = url($row);
        }
        try {

            $data = $this->getAiResponse($post, $chart);
            if ($chart->type == 'line') {
                if (count($data->series->line) == 1) {$date = $data->series->line[0];
                    // return [$date];
                    ChartLineOutput::whereJsonContains('output', ['date' => $date->date])->delete();

                    $saved = [
                        'output' => json_encode($data->series->line[0]),
                        'chart_id' => $chart->id,
                    ];

                    ChartLineOutput::create($saved);

                    $output = ChartLineOutput::where('chart_id', $chart_id)->get()->pluck('output');

                    $output = [
                        'series' => $output,
                        'weights' => $data->series->weights,
                        'EffsBar' => $data->series->summary->EffsBar,
                        'paretoRanking' => $data->series->summary->paretoRanking,
                        'InputWeights' => $data->series->summary->InputWeights,
                        'OutputWeights' => $data->series->summary->OutputWeights,
                        'correlation' => $data->series->summary->correlation,
                        'description' => $data->series->summary->description,

                    ];
                    if ($forStory == true) {
                        return $output;
                    }

                    return response()->json($output);
                } else {
                    return response()->json([
                        'series' => $data->series->line,
                        'weights' => $data->series->weights,
                    ]);
                }

            } else {
                if ($forStory == true) {
                    return $data->series;
                }
                return response()->json($data);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'something went wrong while file reading',
            ], 500);
        }

    }
    public function getAiResponse($data, $chart)
    {
        $type = $chart->type == 'column' ? 'bar' : $chart->type;

        if (strtolower($chart->type) == 'line') {
            $post = [
                'files' => $data,
                'type' => strtolower($type),
                'input' => $chart->input_index ?? [1],
                'output' => $chart->output_index ?? [2],
            ];
        } else {
            $post = [
                'files' => $data,
                'type' => strtolower($type),
            ];
        }
        // return $post;
        $url = env('AI_API') . '/analysis';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // execute!
        $result = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        return json_decode($result);
    }

    public function EditExcelData(Request $request)
    {
        $request->validate([
            'chart_id' => 'required',
            'file_name' => 'required',
            'column_index' => 'required',
            'row_index' => 'required',
            'page_num' => 'required',
            'page_limit' => 'required',
        ]);
        $limit = $request->page_limit;
        $offset = $limit * ($request->page_num - 1);
        $itemIndex = $offset + $request->row_index;

        $file = file_get_contents(public_path($request->file_name));
        $file = json_decode($file);

        if (($request->page_num == 1 && $request->column_index == 0) || $request->row_index == 0) {
            $value = $request->value;

        } else {
            $value = $request->value;

        }
        $file[$itemIndex][$request->column_index] = $value;
        // return $file;
        file_put_contents(public_path($request->file_name), collect($file));

        return response()->json([
            'message' => 'data has been saved successfully',
        ]);
    }

    public function removeColumn(Request $request)
    {
        $request->validate([
            'file_name' => 'required',
            'column_index' => 'required',
            'type' => 'required|in:column,row',
            'page_num' => 'required',
            'page_limit' => 'required',
        ]);
        $index = $request->column_index;
        $file = file_get_contents(public_path($request->file_name));
        $file = json_decode($file);
        $newFile = [];
        if ($request->type == 'column') {
            foreach ($file as $row) {
                // return $row[$index];
                unset($row[$index]);
                $newFile[] = array_values($row);
                # code...
            }
        } else {
            $limit = $request->page_limit;
            $offset = $limit * ($request->page_num - 1);
            $itemIndex = $offset + $index;

            $newFile = $file;
            unset($newFile[$itemIndex]);
            $newFile = array_values($newFile);
        }

        file_put_contents(public_path($request->file_name), collect($newFile));

        return response()->json([
            'message' => 'data has been saved successfully',
        ]);
    }

    public function addColumn(Request $request)
    {

        $request->validate([
            'file_name' => 'required',
            'value' => 'required',
            'type' => 'required|in:row,column',
        ]);

        $file = file_get_contents(public_path($request->file_name));
        $file = json_decode($file);
        $newFile = [];
        if ($request->type == 'column') {
            foreach ($file as $index => $row) {
                if ($index == 0) {
                    array_push($row, $request->value);
                } else {
                    array_push($row, 0);
                }
                $newFile[] = $row;
            }
        } else {
            $newFile = $file;
            $newArr = [];
            $columnLength = count($newFile[0]);
            for ($i = 0; $i < $columnLength; $i++) {
                if ($i == 0) {
                    $newArr[] = $request->value;
                } else {
                    $newArr[] = 0;
                }
            }
            $newFile[] = $newArr;
        }

        file_put_contents(public_path($request->file_name), collect($newFile));

        return response()->json([
            'message' => 'data has been saved successfully',
        ]);
    }
}
