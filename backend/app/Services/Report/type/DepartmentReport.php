<?php

namespace App\Services\Report\type;

use App\Exceptions\GeneralException;
use App\Services\Report\BaseReport;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use JsonException;

class DepartmentReport extends BaseReport
{
    public $query = null;
    public string $mainTable;
    public array $filter;

    /**
     * @param $filter
     */
    public function __construct($filter)
    {
        $this->mainTable = 'DEPT';
        $this->filter = $filter;
    }

    /**
     * @return array
     * @throws GeneralException
     */
    public function report(): array
    {
        try {
            $this->prepare();

            return $this->getReport();

        } catch (Exception $e) {
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     */
    public function prepare(): void
    {
        $this->filter['format_date'] = $this->guessDateFormat(@$this->filter['start'], @$this->filter['end']);

        $func_name = camelCase($this->filter['type']) . "Query";

        if (method_exists($this, $func_name)) {
            $this->query = $this->$func_name();
        }
    }

    /**
     * @throws JsonException
     */
    public function getReport(): array
    {
        if (empty($this->query)) {
            return [];
        }

        $data = json_decode($this->query->groupBy($this->filter['groupBy'])
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->{$this->filter['groupBy']} => $item];
            }), true, 512, JSON_THROW_ON_ERROR);;


        return $data;
    }

    /**
     * @return Builder
     */
    private function departmentStatusQuery(): Builder
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.DEPT_NO) as {$this->filter['columns'][0]}"),
                "$this->mainTable.DEPT_DESC as {$this->filter['groupBy']}"
            );
    }


    /**
     * @return Builder
     */
    private function departmentAgeQuery(): Builder
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.DEPT_NO) as {$this->filter['columns'][0]}"),
                DB::raw("TIMESTAMPDIFF(YEAR,employees.BIRTHDATE,NOW()) as {$this->filter['groupBy']}")
            )->join("V_ALL_USER_EMP_INFO as employees", "$this->mainTable.DEPT_NO", "=", "employees.DEPARTMENTID");
    }
}
