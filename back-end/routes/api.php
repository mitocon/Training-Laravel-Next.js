<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SecuritiesReportController;

Route::get('/get_xbrl_from_edinet', [SecuritiesReportController::class, 'getXBRLFromEdinet']);

Route::get('/healthcheck', function () {
    return response()->json(['status' => 'OK']);
});
