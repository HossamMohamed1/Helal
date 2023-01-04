<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Support\Arr;

class ReportService
{
    /**
     * @param $type
     * @return false|mixed
     */
    public static function prepareObject($type)
    {
        $path = "\\App\\Services\\Report\\".config("report.type.$type.className");

        $reportClass = new $path();

        return is_object($reportClass) ? $reportClass : false;
    }

    /**
     * @throws Exception
     */
    public static function report($filter)
    {
        try {
            if (!$reportObject = self::prepareObject($filter['type'])) {
                return false;
            }

            $data = $reportObject->report($filter) ?? [];

            $charts = Arr::wrap($filter['charts']);

            // //prepare data for each chart by ChartService
            // foreach ($charts as $chart) {
            //     $method = 'prepare' . ucfirst($chart);
            //     if (method_exists(new ChartService(), $method)) {
            //         $result[$chart] = ChartService::$method($data, $filter);
            //     }
            // }

            return $data ?? [];
        } catch (Exception $e) {
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     * @param null $filter
     * @return array|bool
     * @throws Exception
     */
    public static function cards($filter = null)
    {
        try {
            if (!$reportObject = self::prepareObject($filter['type'])) {
                return false;
            }

            return $reportObject->report($filter) ?? [];
        } catch (Exception $e) {
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     * @param $type
     * @return array|false
     */
    public function getReportList($type)
    {
        return config("report.type.$type") ?? false;
    }
}
