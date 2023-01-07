<?php

namespace App\Services\Report;

use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use JsonException;

class EmployeeReport extends BaseReport
{
    public $queries = [];
    public $mainTable;
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
            $this->query = $this->$func_name($filter);
        }
    }

    /**
     * @throws JsonException
     */
    public function getReport($filter): array
    {
        $result = [];
     
        $result = $this->query->first();
        dd($result);
        $data = json_decode($this->query->get()
                    ->mapWithKeys(function ($item) use ($filter) {
                        return ['list' => $item];
                    }), true, 512, JSON_THROW_ON_ERROR);

        $result = $data;
        

        dd($result);

        return $data;
    }

    /**
     * @param $filter
     */
    private function employeeGenderQuery($filter)
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT(CASE WHEN genderid = 1 then 1 ELSE NULL END) as male"),
                DB::raw("COUNT(CASE WHEN genderid = 2 then 1 ELSE NULL END) as female")
            );
    }

    /**
     * @param $filter
     */
    private function employeeDepartmentQuery($filter)
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->join('', '')
            ->select(
                'departments', ''
            );
    }
}