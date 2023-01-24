<?php

namespace App\Services\Report\type;

use App\Exceptions\GeneralException;
use App\Models\Employee;
use App\Services\Report\BaseReport;
use Carbon\Carbon;
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

        $query = DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )
            ->join('dept', 'departmentid', '=', 'dept.dept_no');

        if (!empty($this->filter['category'])) {
            $query->join('dept parent', 'parent.dept_no', '=', 'dept.dept_parent')
                ->where('parent.dept_desc', $this->filter['category'])
                ->orWhere('dept.dept_desc', $this->filter['category']);
        }

        return $query->groupBy($this->filter['groupBy'])
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
        $query = DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT(emp_no) as {$this->filter['columns'][0]}"),
                'dept.' . $this->filter['groupBy'],
            )
            ->join('dept', 'departmentid', '=', 'dept.dept_no');

        if (!empty($this->filter['category'])) {
            $query->join('dept parent', 'parent.dept_no', '=', 'dept.dept_parent')
                ->where('parent.dept_desc', $this->filter['category'])
                ->orWhere('dept.dept_desc', $this->filter['category']);
        }
        return $query->groupBy('dept.' . $this->filter['groupBy'])->get();
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

        $query = Employee::select(
            DB::raw("COUNT(emp_no) as count"),
            'location_no',
        );

        if (!empty($this->filter['category'])) {
            $category = $this->filter['category'];
            $query = $query->addSelect('departmentId')
                ->whereHas('department', function ($q) use ($category) {
                    return $q->whereHas('parentDepartment', function ($q) use ($category) {
                        return $q->where('dept_desc', $category);
                    });
                })
                ->orWhereHas('department', function ($q) use ($category) {
                    return $q->where('dept_desc', $category);
                })
                ->groupBy('location_no', 'departmentId');
        } else {
            $query = $query->groupBy('location_no');
        }

        return $query->get()
            ->map(function ($item) use ($labels) {
                $item->{$this->filter['groupBy']} = $labels[$item->{$this->filter['groupBy']}] ?? $$item->{$this->filter['groupBy']};
                return $item;
            });
        // $query = DB::connection('oracle')
        //     ->table($this->mainTable)
        //     ->select(
        //         DB::raw("COUNT(emp_no) as {$this->filter['columns'][0]}"),
        //         $this->filter['groupBy'],
        //     );
        // // ->join('dept', 'departmentid', '=', 'dept.dept_no');

        // return $query->groupBy($this->filter['groupBy'])
        //         ->get()
        //         ->map(function ($item) use ($labels) {
        //             $item->{$this->filter['groupBy']} = $labels[$item->{$this->filter['groupBy']}] ?? $$item->{$this->filter['groupBy']};
        //             return $item;
        //         });

        // $query = DB::connection('oracle')
        //     ->table($this->mainTable)
        //     ->select(
        //         DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
        //         $this->filter['groupBy']
        //     )
        //     ->join('dept',$this->mainTable. '.departmentid', '=', 'dept.dept_no');
        // return $query->groupBy($this->filter['groupBy'])
        //     ->get()
        //     ->map(function ($item) use ($labels) {
        //         $item->{$this->filter['groupBy']} = $labels[$item->{$this->filter['groupBy']}] ?? $$item->{$this->filter['groupBy']};
        //         return $item;
        //     });
    }

    /**
     * @return Collection
     */
    private function employeeNationalityQuery(): Collection
    {
        $labels = [
            1 => 'سعودى',
            27 => 'غير سعودى',
            2 => 'غير سعودى',
            126 => 'غير سعودى',
        ];
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.EMP_NO) as {$this->filter['columns'][0]}"),
                $this->filter['groupBy']
            )->groupBy($this->filter['groupBy'])
            ->get()
            ->map(function ($item) use ($labels) {
                // return $item;
                // dd($item->{$this->filter['groupBy']});
                $item->{$this->filter['groupBy']} = $labels[$item->{$this->filter['groupBy']}] ?? $item->{$this->filter['groupBy']};
                return $item;
            });
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
            ->get()
            ->map(function ($item) {
                if (empty($item->major_desc)) {
                    $item->major_desc = 'قبل الثانوية';
                }
                return $item;
            });
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
            ->table("v_hadir_late")
            ->select(
                DB::raw('count(employee_id) as attendance'),
                DB::raw('count(case WHEN is_late = 1 then 1 end) as late'),
                DB::raw('count(case WHEN is_late = 0 then 1 end) as no_late'),
                DB::raw('count(case when is_early = 1 then 1 end) as early'),
                'late_date'
            )
            ->whereDate('late_date', '>=', now()->format('Y-m-01'))
        // to_char(sysdate,'DD/MM/YYYY')
            ->groupBy('late_date')
            ->orderBy('late_date', 'ASC')
            ->get()
            ->map(function ($item) {
                $item->late_date = (new Carbon($item->late_date))->toFormattedDateString();
                return $item;
            });

    }

    /**
     * @return Collection
     */
    private function employeeAgeQuery(): Collection
    {
        $query = Employee::select('birthdate')
            ->join('dept', 'departmentid', '=', 'dept.dept_no');

        if (!empty($this->filter['category'])) {
            $query->join('dept parent', 'parent.dept_no', '=', 'dept.dept_parent')
                ->where('parent.dept_desc', $this->filter['category'])
                ->orWhere('dept.dept_desc', $this->filter['category']);
        }

        return $query->get()
            ->groupBy('age')
            ->mapWithKeys(function ($item, $key) {
                return [$key => ['count' => count($item), 'age' => $key]];
            });
    }

    private function employeeRetirementQuery()
    {
        $query = Employee::select('birthdate')
            ->join('dept', 'departmentid', '=', 'dept.dept_no');

        if (!empty($this->filter['category'])) {
            $query->join('dept parent', 'parent.dept_no', '=', 'dept.dept_parent')
                ->where('parent.dept_desc', $this->filter['category'])
                ->orWhere('dept.dept_desc', $this->filter['category']);
        }
        return $query->orderBy('birthdate', 'ASC')
            ->get()
            ->groupBy('age')
            ->mapWithKeys(function ($item, $key) {
                return [$key => ['count' => count($item), 'age' => $key]];
            })
            ->filter(function ($item) {
                return $item['age'] >= 56 && $item['age'] < 60;
            })
            ->map(function ($item) {
                $item['age'] = 60 - $item['age'];
                $item['age'] = $item['age'] . ' سنه';
                return (object) $item;
            });
    }

    public function cards()
    {
        $result = DB::connection('oracle')
            ->table('v_all_user_emp_info')
            ->select(
                DB::raw("count(*) as emps"),
                DB::raw("COUNT(CASE WHEN genderid = '1'  THEN 1 END) as males"),
                DB::raw("COUNT(CASE WHEN genderid = '2'  THEN 1 END) as females"),
            )
            ->where('v_all_user_emp_info.end_date', '>', now())
            ->first();

        $result->attendees = $result->emps - DB::connection('oracle')->table('absence')
            ->join('v_all_user_emp_info', 'absence.employee_id', '=', 'emp_no')
            ->select(DB::raw('COUNT(employee_id) as absence'), 'absence_date')
            ->where('absence_date', now()->format('Y/m/d '))
            ->where('v_all_user_emp_info.end_date', '>', now())
            ->groupBy('absence_date')
            ->first()->absence ?? 0;

        return $result;
    }

    public function ageDistributionForEmployeesQuery()
    {
        $query = Employee::select('birthdate')
            ->join('dept', 'departmentid', '=', 'dept.dept_no');

        if (!empty($this->filter['category'])) {
            $query->join('dept parent', 'parent.dept_no', '=', 'dept.dept_parent')
                ->where('parent.dept_desc', $this->filter['category'])
                ->orWhere('dept.dept_desc', $this->filter['category']);
        }

        return $query->orderBy('birthdate', 'DESC')
            ->get()
            ->groupBy('age')
            ->mapWithKeys(function ($item, $key) {
                return [$key => ['count' => count($item), 'age' => $key]];
            })
            ->map(function ($item) {
                if ($item['age'] < 30) {
                    $item['age'] = 'اقل من 30';
                } else if ($item['age'] >= 30 && $item['age'] < 40) {
                    $item['age'] = '30 - 40';
                } else if ($item['age'] >= 40 && $item['age'] <= 50) {
                    $item['age'] = '40 - 50';
                } else {
                    $item['age'] = 'اكبر من 50';
                }

                return (object) $item;
            });
    }

    public function employeePublicDepartmentQuery()
    {
        return DB::connection('oracle')->table('dept')
            ->select('dept.dept_desc', DB::raw('count(v_all_user_emp_info.emp_no) as count'))
            ->join('V_ALL_USER_EMP_INFO', 'V_ALL_USER_EMP_INFO.departmentid', '=', 'dept.dept_no')
            ->where('dept_parent', '1')
            ->groupBy('dept.dept_desc')
            ->get();
    }
}