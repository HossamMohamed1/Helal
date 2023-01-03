<?php

namespace App\Services\Chart;

class PieChart implements BaseChartInterface
{
    /**
     * @return array
     */
    public function config(): array
    {
        return [
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

    public function img(): string
    {
        return 'pie.jpg';
    }
}