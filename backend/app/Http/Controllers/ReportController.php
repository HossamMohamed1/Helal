<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Employee;
use App\Services\Report\ReportService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return JsonResponse|RedirectResponse
     * @throws Exception
     */
    public function charts(ReportRequest $request)
    {
        try {
            $filter = $request->all();

            if (!$options = ReportService::getReportOption($request->type)) {
                if ($request->expectsJson()) {
                    return errorMessage('Not found any report for this type');
                }
                abort(400, 'Not found any report for this type');
            }

            $filter += $options;
            if (!$result = ReportService::report($filter)) {
                if ($request->expectsJson()) {
                    return errorMessage('Error In Show Report');
                }
                abort(400, 'Error In Show Report');
            }

            return successData($result);
        } catch (\Exception $e) {
            return errorMessage($e->getMessage());
        }
    }

    public function employee()
    {
        try {
            $employe = Employee::get();

            return response()->json([
                'emp' => $employe,
            ]);
        } catch (\Throwable $th) {
            abort(400, 'Error In Show Report');
        }
    }

    public function statistics()
    {
        $result = DB::connection('oracle')
            ->table('v_all_user_emp_info')
            ->select(
                DB::raw("count(*) as emps"),
                DB::raw("COUNT(CASE WHEN genderid = '1'  THEN 1 END) as males"),
                DB::raw("COUNT(CASE WHEN genderid = '2'  THEN 1 END) as females")
            )->first();

        return successData($result);
    }
}