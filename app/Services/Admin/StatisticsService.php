<?php

namespace App\Services\Admin;

use App\Contracts\CommentServiceInterface;
use App\Contracts\StatisticsServiceInterface;
use App\Contracts\VisitServiceInterface;
use App\Models\Post;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Inertia\Inertia;

class StatisticsService implements StatisticsServiceInterface
{
    public function __construct()
    {
    }

    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Statistics/Index', [
            'day' => $this->get(Carbon::today()->startOfDay()),
            'week' => $this->get(Carbon::now()->subWeek()->addDay()->startOfDay(), Carbon::now()),
            'month' => $this->get(Carbon::now()->subMonth()->addDay()->startOfDay(), Carbon::now()),
        ]);
    }

    public function get(Carbon $from, Carbon $to = null): array
    {
        if (is_null($to)) {
            $to = $from->clone()->endOfDay();
        }

        $visitService = app(VisitServiceInterface::class);
        $visits = $visitService->getStatistics((new Post())->getMorphClass(), $from, $to);

        $commentService = app(CommentServiceInterface::class);
        $comments = $commentService->getStatistics($from, $to);

        $period = CarbonPeriod::create($from, $to);

        $statistics = [];
        foreach ($period as $date) {
            $statistics[$date->format('Y-m-d')] = [
                'visits' => $visits->get($date->format('Y-m-d'))?->count ?? 0,
                'comments' => $comments->get($date->format('Y-m-d'))->count ?? 0,
            ];
        }
        return $statistics;
    }
}
