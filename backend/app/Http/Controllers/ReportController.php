<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Exception;
use Illuminate\Contracts\View\View;
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
     * @return View|RedirectResponse|JsonResponse
     * @throws Exception
     */
    public function charts(Request $request)
    {
        try {
            $filter = $request->all();
            $filter['groupBy'] = $request->groupBy ?? 'list';

            if (!$filter['options'] = ReportService::getReportList($request->type)) {
                if ($request->expectsJson()) {
                    return errorMessage('Not found any report for this type');
                }
                abort(404);
            }

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

}
