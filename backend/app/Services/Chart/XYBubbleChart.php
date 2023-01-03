<?php

namespace App\Services\Chart;

class XYBubbleChart implements BaseChartInterface
{
    /**
     * @return array
     */
    public function config(): array
    {
        return [
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

    public function img(): string
    {
        return 'xybubble.jpg';
    }
}
