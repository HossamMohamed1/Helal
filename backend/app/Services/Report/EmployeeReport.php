<?php

namespace App\Services\Report;

use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use JsonException;

class EmployeeReport extends BaseReport
{
    public array $queries = [];

    public function __construct()
    {
        $this->mainTable = 'V_ALL_USER_EMP_INFO';
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
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     * @param $filter
     */
    public function prepare($filter): void
    {
        $filter['format_date'] = $this->guessDateFormat(@$filter['start'], @$filter['end']);

        $type = camelCase($filter['type']);
        $func_name = "{$type}Query";

        if (method_exists($this, $func_name)) {
            $queries[$type] = $this->$func_name($filter, $filter['type_list'][$type] ?? []);
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
            $data = json_decode($query->get()
                ->mapWithKeys(function ($item) use ($filter) {
                    return [$item->{$filter['groupBy']} => $item];
                }), true, 512, JSON_THROW_ON_ERROR);

            $columns = $filter['columns']['data'];

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
     * @return Builder
     */
    private function employeeGenderQuery($filter): Builder
    {
        return DB::table($this->mainTable)->select(
            DB::raw("COUNT(CASE WHEN genderid = 1 then 1 ELSE NULL END) as male"),
            DB::raw("COUNT(CASE WHEN genderid = 2 then 1 ELSE NULL END) as female")
        );
    }
}
