<?php

namespace App\Services\Report\type;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Exceptions\GeneralException;
use App\Services\Report\BaseReport;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use JsonException;

class DepartmentReport extends BaseReport
{
    public $result = null;
    public $mainTable;
    public $filter;

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

    public function prepare(): void
    {
        $this->filter['format_date'] = $this->guessDateFormat(@$this->filter['start'], @$this->filter['end']);

        $func_name = camelCase($this->filter['type']) . "Query";

        if (method_exists($this, $func_name)) {
            $this->result = $this->$func_name();
        }
    }

    /**
     * @return array
     * @throws JsonException
     */
    public function getReport(): array
    {
        if (empty($this->result)) {
            return [];
        }

        if ($this->filter['type'] == 'department_age') {
            return json_decode($this->result, true, 512, JSON_THROW_ON_ERROR);
        }

        return json_decode($this->result
                ->mapWithKeys(function ($item) {
                    return [$item->{$this->filter['groupBy']} => $item];
                }), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return Collection
     */
    private function departmentStatusQuery(): Collection
    {
        $labels = [
            0 => 'غير نشط',
            1 => 'نشط',
        ];

        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.DEPT_NO) as {$this->filter['columns'][0]}"),
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
    private function departmentLocationQuery(): Collection
    {
        $labels = [
            1 => 'مكة المكرمة',
            2 => 'المدينة المنورة',
        ];

        return DB::connection('oracle')
            ->table($this->mainTable)
            ->select(
                DB::raw("COUNT($this->mainTable.DEPT_NO) as {$this->filter['columns'][0]}"),
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
    private function departmentAgeQuery(): Collection
    {
        return DB::connection('oracle')
            ->table($this->mainTable)
            ->join("V_ALL_USER_EMP_INFO as employees", "{$this->mainTable}.DEPT_NO", "=", "employees.DEPARTMENTID")
            ->select("employees.birthdate", "{$this->mainTable}.dept_desc")
            ->where("{$this->mainTable}.dept_status", '=', '1')
            ->get()
            ->map(function ($item) {
                $item->birthdate = (int) round(Carbon::parse(Hijri::Date('Y-m-d'))->diffInMonths($item->birthdate) / 12);
                return $item;
            })->groupBy('dept_desc')
            ->map(function ($item, $key) {
                return [
                    'birthdate' => (int) round($item->avg('birthdate')),
                    'dept_desc' => $key,
                ];
            });
    }

    private function departmentLessFiveEmployeeQuery()
    {
        $query = DB::connection('oracle')
            ->table('dept')
            ->join("V_ALL_USER_EMP_INFO as employees", "{$this->mainTable}.DEPT_NO", "=", "employees.DEPARTMENTID")
            ->select(
                DB::raw("count(emp_no) as {$this->filter['columns'][0]}"),
                "{$this->mainTable}.{$this->filter['groupBy']}"
            )
            ->where("{$this->mainTable}.dept_status", '=', '1')
            ->groupBy("{$this->mainTable}.{$this->filter['groupBy']}")
            ->get()
            ->sortBy($this->filter['groupBy'])
            ->filter(function ($item) {
                return $item->count <= 5;
            });

        return $query;
    }
}