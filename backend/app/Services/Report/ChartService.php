<?php

namespace App\Services\Report;

use Illuminate\Support\Arr;

class ChartService
{
    /**
     * prepare data to coincide Bar Chart
     *
     * @param $data
     * @param $filter
     * @return array
     */
    public static function prepareBar($data, $filter): array
    {
        $result = [];
        $result['labels'] = array_keys($data);

        foreach ($filter['columns'] as $column) {
            $value = array_values(Arr::pluck($data, $column));
            $result['result'][] = [
                'name' => handleTrans($column),
                'data' => $value,
            ];
        }

        return $result;
    }

    /**
     * Prepare data to coincide Line chart
     *
     * @param $data
     * @param $filter
     * @return array
     */
    public static function prepareLine($data, $filter): array
    {
        $result = [];
        $result['labels'] = array_keys($data);

        foreach ($filter['columns'] as $column) {
            $value = array_values(Arr::pluck($data, $column));
            $result['result'][] = [
                'name' => handleTrans($column),
                'data' => collect($value)->map(function ($item) {
                    return (int) $item;
                }),
            ];
        }

        return $result;
    }

    /**
     * prepare data to coincide Pie Chart
     *
     * @param $data
     * @param $filter
     * @return array
     */
    public static function preparePie($data, $filter): array
    {
        $result = [];
        foreach ($filter['columns'] as $column) {
            $result[$column] = [
                'labels' => array_filter(Arr::pluck($data, $filter['groupBy'])),
                'result' => array_values(array_map(static fn($item) => (int) $item, Arr::pluck($data, $column))) ?? [0],
            ];
        }

        if (count($result) == 1) {
            $result = Arr::first($result);
        }

        return $result ?? [];
    }

    /**
     * prepare data to coincide Table Chart
     *
     * @param $data
     * @return array
     */
    public static function prepareTable($data): array
    {
        $final = array_values($data);

        return [
            'table' => $final,
            'columns' => array_keys($final[0] ?? [])
        ];
    }
}