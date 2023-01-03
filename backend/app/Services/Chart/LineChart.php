<?php

namespace App\Services\Chart;

class LineChart implements BaseChartInterface
{
    /**
     * @return array
     */
    public function config(): array
    {
        return [
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
            "yLabel" => "", //Default Empty string
            "colors" => ["#256624", "#8b92a1", "#c0ca33", "#795548", "#546e7a", "#303f9f", "#ff5722"],
            //"zoom" => true,
            "zoom" => [
                "cursor" => "zoomXY",
                "scrollbarX" => "true",
                "scrollbarY" => "true",
                "scrollbarXBottom" => "top",
                "scrollbarYLeft" => "right",
            ],
            "style" => [
                "backgroundColor" => "#fff",
            ],

        ];
    }

    public function img(): string
    {
        return 'line.jpg';
    }
}
