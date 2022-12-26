<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charts = Chart::all();
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
            'data' => 'nullable',
            'config' => 'nullable',
        ]);
        $requestData = $request->only(['name', 'type', 'data', 'config']);

        // if ($request->type == 'Network' || $request->type == 'network') {
        // check for string with upper case like this
         if (strtolower($request->type) == 'network') {
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

        } else if ($request->type == 'Pie' || $request->type == 'pie') {
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
                    "disabled" => false,
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
                    "backgroundColor" => "#ececec",
                ],

            ];

        } else if (strtolower($request->type) == 'bar' || strtolower($request->type) == 'column') {
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
                    "disabled" => false,
                    "name" => "chart name",
                    "align" => "center",
                    "position" => "bottom", // Top or Bottom
                    "paddingBottom" => 20, // if Position is Top
                    "paddingTop" => 20, // if Position is Bottom
                ],
                "xLabel" => [
                    "text" => "", //Default Empty string
                    "paddingTop" => "10",
                ],
                "yLabel" => "", //Default Empty string
                "colors" => ["#256624", "#8b92a1", "#c0ca33", "#795548", "#546e7a", "#303f9f", "#ff5722"],
                "zoom" => true,
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
                    "backgroundColor" => "#ececec",
                ],
            ];

        } else if ($request->type == 'Line' || $request->type == 'line') {
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
                    "disabled" => false,
                    "align" => "center",
                    "position" => "bottom", // Top or Bottom
                    "paddingBottom" => 10, // if Position is Top
                    "paddingTop" => 20, // if Position is Bottom
                ],
                "xLabel" => [
                    "text" => "", //Default Empty string
                    "paddingTop" => "10",
                ],
                "yLabel" => " ", //Default Empty string
                "colors" => ["#256624", "#8b92a1", "#c0ca33", "#795548", "#546e7a", "#303f9f", "#ff5722"],
                "zoom" => true,
                "style" => [
                    "backgroundColor" => "#ececec",
                ],

            ];

        } else if (strtolower($request->type) == 'xybubble') {
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
                    "backgroundColor" => "#ececec",
                ],
            ];
        }

        $chart = Chart::create($requestData);
        return response()->json(['chart' => $chart], 200);
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
        $chart = Chart::find($id);
        if(!$chart) {
            return response()->json(['message' => 'Chart Not Found'], 200);
        }
            
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
        Log::info(collect($requestData));
        $chart = Chart::find($id);
        if(!$chart) {
            return response()->json(['message' => 'Chart Not Found'], 200);
        }
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
}
