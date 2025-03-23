<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\StatisticsService;

class StatisticsController extends Controller
{
    public function index(StatisticsService $statisticsService)
    {
        return $statisticsService->index();
    }
}
