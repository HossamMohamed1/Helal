<?php

namespace App\Services\Chart;

class NetworkChart implements BaseChartInterface
{
    /**
     * @return array
     */
    public function config(): array
    {
        return [
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

    public function img(): string
    {
        return 'network.jpg';
    }
}
