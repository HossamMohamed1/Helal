<?php

namespace App\Services\Chart;

use App\Exceptions\ChartNotDefined;
use App\Exceptions\ChartTypeException;
use Exception;

class ChartFactory
{
    /**
     * @var string[]
     */
    protected static  $charts = ['Network', 'Bar', 'Line', 'XYBubble', 'Pie'];

    /**
     * Handle Creating object for correct chart type
     *
     * @throws Exception
     */
    public static function handle($type)
    {
        //ensure type in available charts
        if (!in_array($type, self::$charts, true)) {
            throw new ChartTypeException();
        }

        //Detect class of chart type
        $className = "{$type}Chart";
        $full_name = "\App\\Services\Chart\\" . $className;

        try {
            return new $full_name();

        } catch (\Throwable $e) {
            throw new ChartNotDefined();
        }
    }
}
