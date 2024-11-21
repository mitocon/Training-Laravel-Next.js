<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SecuritiesReportController;

Route::get('/get_securities_report', [SecuritiesReportController::class, 'getXBRLFromEdinet']);

Route::get('/healthcheck', function () {
    return response()->json(['status' => 'OK']);
});
