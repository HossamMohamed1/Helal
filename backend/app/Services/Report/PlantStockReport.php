<?php

namespace App\Services\Report;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use JsonException;

class PlantStockReport extends BaseReport
{
    public array $queries = [];

    public function __construct()
    {
        $this->mainTable = 'plant_stock';
        $this->detailsTable = 'plant_stock_days';
    }


    /**
     * @param $filter
     * @return array
     * @throws Exception
     */
    public function report($filter): array
    {
        try {
            $this->prepare($filter);

            return $this->getReport($filter);

        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $filter
     */
    public function prepare($filter): void
    {
        $filter['format_date'] = $this->guessDateFormat($filter['start'], $filter['end']);

        foreach ($filter['type_list'] as $type => $columns) {
            $func_name = "prepare{$type}Query";
            if (method_exists($this, $func_name)) {
                $queries[$type] = $this->$func_name($filter, $filter['type_list'][$type] ?? []);
            }
        }

        $this->queries = $queries ?? [];
    }

    /**
     * @throws JsonException
     */
    public function getReport($filter): array
    {
        $result = [];
        foreach ($this->queries as $key => $query) {
            $filter['column'] = "$this->detailsTable.day";
            $query = $this->handleDateFilter($query, $filter);

            $data = json_decode($query->groupBy($filter['groupBy'])
                ->get()
                ->mapWithKeys(function ($item) use ($filter) {
                    return [$item->{$filter['groupBy']} => $item];
                }), true, 512, JSON_THROW_ON_ERROR);

            $columns = $filter['type_list'][$key];

            $result[$key] = collect($data)->map(function ($item) use ($columns) {
                foreach ($columns as $column) {
                    if (!isset($item[$column])) {
                        $item[$column] = 0;
                    }
                }
                return $item;
            })->toArray();
        }

        return $result;
    }

    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareActualExportQuery($filter, $listKeys): Builder
    {
        return DB::table($this->detailsTable)
            ->join($this->mainTable, "{$this->detailsTable}.plant_stock_id", '=', "{$this->mainTable}.id")
            ->select(
                DB::raw("(DATE_FORMAT($this->detailsTable.day, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("SUM($this->detailsTable.export) as '" . __('dashboard.value') . "'")
            )->where("$this->mainTable.plant", 'Jubail');
    }

    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareWaterStockQuery($filter, $listKeys): Builder
    {
        return DB::table($this->detailsTable)
            ->join($this->mainTable, "{$this->detailsTable}.plant_stock_id", '=', "{$this->mainTable}.id")
            ->select(
                DB::raw("(DATE_FORMAT($this->detailsTable.day, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("SUM($this->detailsTable.stock) as  '" . __('dashboard.value') . "'")
            )->where("$this->mainTable.plant", 'Jubail');
    }


    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function preparePowerProducationQuery($filter, $listKeys): Builder
    {
        return DB::table($this->detailsTable)
            ->join($this->mainTable, "{$this->detailsTable}.plant_stock_id", '=', "{$this->mainTable}.id")
            ->select(
                DB::raw("(DATE_FORMAT($this->detailsTable.day, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("SUM($this->detailsTable.power) as   '" . __('dashboard.value') . "'")
            )->where("$this->mainTable.plant", 'Jubail');
    }

    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareCompareValueQuery($filter, $listKeys): Builder
    {
        return DB::table($this->detailsTable)
            ->join($this->mainTable, "{$this->detailsTable}.plant_stock_id", '=', "{$this->mainTable}.id")
            ->select(
                DB::raw("(DATE_FORMAT($this->detailsTable.day, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("SUM($this->detailsTable.export) as'" . __('dashboard.actual_export') . "'"),
                DB::raw("SUM($this->detailsTable.stock) as '" . __('dashboard.water_stock') . "'"),
                DB::raw("SUM($this->detailsTable.power) as '" . __('dashboard.power_prod') . "'")
            )->where("$this->mainTable.plant", 'Jubail');
    }
}
