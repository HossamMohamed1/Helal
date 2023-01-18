<?php

namespace App\Services\Report\type;

use App\Exceptions\GeneralException;
use App\Models\Employee;
use App\Services\Report\BaseReport;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use JsonException;

class EmployeeReport extends BaseReport
{
    public $result = null;
    public $mainTable;
    public $filter;

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
            $this->result = $this->$func_name();
        }
    }

    /**
     * @throws JsonException
     */
    public function getReport(): array
    {
        if (empty($this->result)) {
            return [];
        }

        if ($this->filter['type'] == 'employee_age') {
            return $this->result->toArray();
        }

        return json_decode($this->result
                ->mapWithKeys(function ($item) {
                    return [$item->{$this->filter['groupBy']} => $item];
                }), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return Collection
     */
    private function employeeGenderQuery(): Collection
    {
        $labels = [
            1 => 'ذكر',
            2 => 'أنثى',
        ];

        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get()
            ->map(function ($item) use ($labels) {
                $item->{$this->filter['groupBy']} = $labels[$item->{$this->filter['groupBy']}] ?? $$item->{$this->filter['groupBy']};
                return $item;
            });
    }

    /**
     * @return Collection
     */
    private function employeeDepartmentQuery(): Collection
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get();
    }

    /**
     * @return Collection
     */
    private function employeeLocationQuery(): Collection
    {
        $labels = [
            1 => 'مكة المكرمة',
            2 => 'المدينة المنورة',
        ];

        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get()
            ->map(function ($item) use ($labels) {
                $item->{$this->filter['groupBy']} = $labels[$item->{$this->filter['groupBy']}] ?? $$item->{$this->filter['groupBy']};
                return $item;
            });
    }

    /**
     * @return Collection
     */
    private function employeeNationalityQuery(): Collection
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get();
    }

    /**
     * @return Collection
     */
    private function employeeJobQuery(): Collection
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get();
    }

    /**
     * @return Collection
     */
    private function employeeMajorQuery(): Collection
    {
        return DB::connection('oracle')
            ->table("EMPLOYEE_QUALIFICATION")
            ->select(
                DB::raw("COUNT(EMPLOYEE_QUALIFICATION.EMPLOYEE_ID) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get();
    }

    /**
     * @return Collection
     */
    private function employeeQualificationQuery(): Collection
    {
        return DB::connection('oracle')
            ->table("EMPLOYEE_QUALIFICATION")
            ->select(
                DB::raw("COUNT(EMPLOYEE_QUALIFICATION.EMPLOYEE_ID) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get();
    }

    /**
     * @return Collection
     */
    private function employeeAbsenceQuery(): Collection
    {
        return DB::connection('oracle')
            ->table("EMPLOYEE_QUALIFICATION")
            ->select(
                DB::raw("COUNT(EMPLOYEE_QUALIFICATION.EMPLOYEE_ID) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get();
    }

    /**
     * @return Collection
     */
    private function employeeAgeQuery(): Collection
    {
        return Employee::select('birthdate')
            ->get()
            ->groupBy('age')
            ->mapWithKeys(function ($item, $key) {
                return [$key => ['count' => count($item), 'age' => $key]];
            });
    }

    public function cards()
    {
        return DB::connection('oracle')
            ->table('v_all_user_emp_info')
            ->select(
                DB::raw("count(*) as emps"),
                DB::raw("COUNT(CASE WHEN genderid = '1'  THEN 1 END) as males"),
                DB::raw("COUNT(CASE WHEN genderid = '2'  THEN 1 END) as females"),
                DB::raw("0 as attendees"),
            )
            ->first();
    }
}