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
            dd($e);
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
            $queries[$filter['type']] = $this->$func_name($filter);
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
        
            $data = $query->first();

            $result[$key] = $data;
        }

        return $result;
    }

    /**
     * @param $filter
     * @return Builder
     */
    private function employeeGenderQuery($filter): Builder
    {
        return DB::connection('oracle')->table($this->mainTable)->select(
            DB::raw("COUNT(CASE WHEN genderid = 1 then 1 ELSE NULL END) as male"),
            DB::raw("COUNT(CASE WHEN genderid = 2 then 1 ELSE NULL END) as female")
        );
    }
}
