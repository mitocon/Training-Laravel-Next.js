<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SecuritiesReportController;

Route::get('/get_xbrl_from_edinet', [SecuritiesReportController::class, 'getXBRLFromEdinet']);

Route::get('/securities_report/list', [SecuritiesReportController::class, 'getSecuritiesReportList']);
Route::get('/securities_report/{company_id}', [SecuritiesReportController::class, 'getSecuritiesReport'])
    ->where('company_id', '[0-9]+');

Route::get('/healthcheck', function () {
    return response()->json(['status' => 'OK']);
});
