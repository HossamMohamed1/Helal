<?php

namespace App\Services\Report\type;

use App\Exceptions\GeneralException;
use App\Services\Report\BaseReport;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use JsonException;

class EmployeeReport extends BaseReport
{
    public $query = null;
    public string $mainTable;
    public array $filter;

    public function __construct($filter)
    {
        $this->mainTable = 'V_ALL_USER_EMP_INFO';
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

        if ($this->filter['type'] == 'employee_gender') {
            $data = collect($this->query->frist())->transform(function ($item, $key) {
                return [
                    $this->filter['groupBy'] => $key,
                    $this->filter['columns'][0] => $item
                ];
            })->toArray();

        } else {
            $data = json_decode($this->query->groupBy($this->filter['groupBy'])
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->{$this->filter['groupBy']} => $item];
                }), true, 512, JSON_THROW_ON_ERROR);;

        }

        return $data;
    }

    /**
     * @return Builder
     */
    private function employeeGenderQuery(): Builder
    {
//        return DB::connection('oracle')
//            ->table($this->mainTable)
//            ->select(
//                DB::raw("COUNT($this->mainTable.EMP_NO"),
//                "$this->mainTable.GENDERID as {$this->filter['groupBy']}"
//            );

        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT(CASE WHEN genderid = 1 then 1 ELSE NULL END) as male"),
                DB::raw("COUNT(CASE WHEN genderid = 2 then 1 ELSE NULL END) as female")
            );
    }

    /**
     * @return Builder
     */
    private function employeeListQuery(): Builder
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select("$this->mainTable.JOB_DESC", "$this->mainTable.DEPT_DESC");
    }

    /**
     * @return Builder
     */
    private function employeeDepartmentQuery(): Builder
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            );
    }

    /**
     * @return Builder
     */
    private function employeeLocationQuery(): Builder
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy'],
                "dept_desc"
            );
    }

    /**
     * @return Builder
     */
    private function employeeJobQuery(): Builder
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            );
    }

    /**
     * @return Builder
     */
    private function employeeAgeQuery(): Builder
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                DB::raw("TIMESTAMPDIFF(YEAR,BIRTHDATE,NOW()) as {$this->filter['groupBy']}")
            );
    }

    /**
     * @return Builder
     */
    private function employeeMajorQuery(): Builder
    {
        return DB::connection('oracle')
            ->table("EMPLOYEE_QUALIFICATION")
            ->select(
                DB::raw("COUNT($this->mainTable.EMPLOYEE_ID) as {$this->filter['columns'][0]}"),
                "$this->mainTable.MAJOR_DESC as {$this->filter['groupBy']}"
            );
    }

    /**
     * @return Builder
     */
    private function employeeQualificationQuery(): Builder
    {
        return DB::connection('oracle')
            ->table("EMPLOYEE_QUALIFICATION")
            ->select(
                DB::raw("COUNT($this->mainTable.EMPLOYEE_ID) as {$this->filter['columns'][0]}"),
                "$this->mainTable.QUALIFICATION_DESC as {$this->filter['groupBy']}"
            );
    }
}
