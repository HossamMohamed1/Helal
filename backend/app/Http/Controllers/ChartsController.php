<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChartRequest;
use App\Http\Resources\JsonDataResource;
use App\Imports\DataImport;
use App\Models\Chart;
use App\Models\ChartFile;
use App\Models\ChartLineOutput;
use App\Services\Chart\ChartFactory;
use Exception;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $charts = Chart::select(['id', 'name', 'img'])->get();

        return response()->json(['charts' => $charts]);
    }

    /**
     * Create Chart with store config for chart
     *
     * @param ChartRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function create(ChartRequest $request): JsonResponse
    {
        $data = $request->validated();

        $chartObj = ChartFactory::handle($request->type); //Get object of current chart

        $data['config'] = $chartObj->config();
        $data['img'] = $chartObj->img();

        $chart = Chart::create($data);

        if ($file = $request->file('file')) {
            $tabs = Excel::toArray(new DataImport(), $file);

            $chart->update(['file_count' => count($tabs)]);

            foreach ($tabs as $key => $tab) {
                $name = time() . '-part-' . ($key + 1) . '.json';
                file_put_contents(public_path('excel/' . $name), collect($tab));

                ChartFile::create([
                    'file_path' => 'excel/' . $name,
                    'file_name' => basename($name),
                    'chart_id' => $chart->id,
                ]);
            }
        }

        return response()->json([
            'chart' => $chart,
            'message' => 'Chart has been successfully created'
        ]);
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $chart = Chart::findOrFail($id);

        return response()->json(['chart' => $chart], 200);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function edit($id, Request $request): JsonResponse
    {
        $requestData = $request->only(['name', 'type', 'data', 'config', 'input_index', 'output_index']);

        $chart = Chart::where('id', $id)->update($requestData);

        return response()->json([
            'message' => 'Chart has been successfully updated',
            'chart' => $chart,
        ]);

    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $chart = Chart::findOrFail($id);

        $files = $chart->files()->get()->pluck('file_path');

        foreach ($files as $file) {
            @unlink(public_path($file));
        }

        $chart->files()->delete();
        $chart->delete();

        return response()->json(['message' => 'Chart Deleted Successfully'], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function importExcel(Request $request): JsonResponse
    {
        $request->validate([
            'chart_id' => 'required',
            'file' => 'required',
        ]);

        $chart = Chart::findOrFail($request->chart_id);

        if (!$chart) {
            return response()->json([
                'message' => 'This chart doesn\'t exists',
            ], 400);
        }

        $tabs = Excel::toArray(new DataImport(),  $request->file('file'));

        $chart->update([
            'file_count' => count($tabs),
        ]);

        // return $tabs;
        foreach ($tabs as $key => $tab) {
            $name = time() . '-part-' . ($key + 1) . '.json';
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
     * @param Request $request
     * @return JsonResponse
     */
    public function showFile(Request $request): JsonResponse
    {
        $data = file_get_contents(public_path($request->file));
        $data = json_decode($data);
        $heads = $data[0];

        $data = $this->paginate(collect($data), $request->perPage ?? 10)->toArray();

        return response()->json([
            'data' => new JsonDataResource($data),
            'heads' => $heads,
        ]);

    }

    /**
     * Paginator  .
     *
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 10, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return (new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options));
    }

    /**
     * Get CHart Files .
     * @param int $id
     * @return JsonResponse
     */
    public function chartFiles($id): JsonResponse
    {
        $chartFiles = ChartFile::where('chart_id', $id)->get();

        return response()->json([
            'data' => $chartFiles,
        ]);
    }

    /**
     * Analysis For Chart Data .
     * @param $chart_id
     * @param bool $forStory
     * @return array|JsonResponse
     */
    public function analysis($chart_id, $forStory = false)
    {
        $post = ChartFile::where('chart_id', $chart_id)
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('file_path')
            ->map(fn($item) => url($item))
            ->toArray();

        $chart = Chart::find($chart_id);

        try {
            $data = $this->getAiResponse($post, $chart);

            if ($chart->type == 'line') {
                if (count($data->series->line) == 1) {
                    $date = $data->series->line[0];
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
                }

                return response()->json([
                    'series' => $data->series->line,
                    'weights' => $data->series->weights,
                ]);
            }

            if ($forStory == true) {
                return $data->series;
            }

            return response()->json($data);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'something went wrong while file reading',
            ], 500);
        }
    }

    /**
     * @param $data
     * @param $chart
     * @return mixed
     */
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

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function EditExcelData(Request $request): JsonResponse
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

        file_put_contents(public_path($request->file_name), collect($file));

        return response()->json([
            'message' => 'data has been saved successfully',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeColumn(Request $request): JsonResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addColumn(Request $request): JsonResponse
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
