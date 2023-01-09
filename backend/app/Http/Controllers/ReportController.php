<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\Report\ReportService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function charts(Request $request)
    {
        try {
            $filter = $request->all();

            if (!$options = ReportService::getReportOption($request->type)) {
                if ($request->expectsJson()) {
                    return errorMessage('Not found any report for this type');
                }
                abort(404);
            }

            $filter += $options;
            if (!$result = ReportService::report($filter)) {
                if ($request->expectsJson()) {
                    return errorMessage('Error In Show Report');
                }
                abort(404);
            }

            return successData($result);
        } catch (\Error $e) {
            return errorMessage($e->getMessage());
        }
    }

    public function employee()
    {

        $employe = Employee::get();

        return response()->json([
            'emp' => $employe
        ]);
        return $employe;
    }

}
