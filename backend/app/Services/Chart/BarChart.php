<?php


namespace App\Services\Chart;

class BarChart implements BaseChartInterface
{
    /**
     * @return array
     */
    public function config(): array
    {
        return [
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
    }

    public function img(): string
    {
        return 'bar.jpg';
    }
}
