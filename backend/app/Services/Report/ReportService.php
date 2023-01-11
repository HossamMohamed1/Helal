<?php

namespace App\Services\Report;

use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Support\Arr;

class ReportService
{
    /**
     * @param $filter
     * @return false|mixed
     */
    public static function prepareObject($filter)
    {
        $type = $filter['type'];

        try {
            $path = "\\App\\Services\\Report\\type\\" . config("report.type.$type.className");

            $reportClass = new $path($filter);

        } catch (Exception $e) {
            return false;
        }

        return is_object($reportClass) ? $reportClass : false;
    }

    /**
     * @throws Exception
     */
    public static function report($filter)
    {
        try {
            if (!$reportObject = self::prepareObject($filter)) {
                return false;
            }

            $data = $reportObject->report() ?? [];

            $charts = Arr::wrap($filter['charts']);

            //prepare data for each chart by ChartService
            foreach ($charts as $chart) {
                $method = 'prepare' . ucfirst($chart);
                if (method_exists(new ChartService(), $method)) {
                    $result[$chart] = ChartService::$method($data, $filter);
                }
            }

            return $result ?? [];
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     * @param $type
     * @return array|false
     */
    public function getReportOption($type)
    {
        return config("report.type.$type") ?? false;
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

}
