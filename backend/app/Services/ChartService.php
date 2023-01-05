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

        foreach ($filter['options']['columns'] as $column) {
            $value = array_values(Arr::pluck($data, $column));
            $result['result'][] = [
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
        foreach ($filter['options']['columns'] as $column) {
            $result[$column] = array_values(collect($data)
                ->transform(function ($item, $key) use ($column) {
                    return ['x' => $key, 'y' => $item[$column]];
                })->toArray());

            $result['name'] = handleTrans($column);

        }

        return $result ?? [];
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

        // foreach ($filter['options']['columns'] as $column) {
        //     $value = array_values(array_map(static fn($item) => (int)$item, Arr::pluck($data, $column)));


            $result = [
                'labels' => $filter['options']['columns'],
                'value' => array_values($data['list']),
            ];

        // }

        return $result ?? [];
    }

    /**
     * prepare data to coincide Table Chart
     *
     * @param $data
     * @param $filter
     * @return array
     */
    public static function prepareTable($data, $filter): array
    {
        
        $final = array_values($data);
        $data = [
            'table' => $final,
            'columns' => array_keys($final[0] ?? [])
        ];
        
        return $data;
    }
}
