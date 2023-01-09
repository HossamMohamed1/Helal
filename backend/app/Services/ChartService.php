<?php

namespace App\Services;

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
            $result[] = [
                'name' => handleTrans($column),
                'data' => $value
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

        foreach ($filter['columns']  as $column) {
            $value = array_values(Arr::pluck($data, $column));
            $result[] = [
                'name' => handleTrans($column),
                'data' => $value
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
        foreach ($filter['columns'] as $column) {
            $value = array_values(array_map(static fn($item) => (int)$item, Arr::pluck($data, $column)));
            $result[$column] = [
                'labels' => array_filter(Arr::pluck($data, $filter['groupBy'])),
                'series' => $value ?? [0],
            ];
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