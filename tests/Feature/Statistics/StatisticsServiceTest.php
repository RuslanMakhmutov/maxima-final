<?php

namespace Tests\Feature\Statistics;
use App\Repositories\VisitRepository;
use App\Services\Admin\StatisticsService;
use App\Services\VisitService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class StatisticsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected VisitRepository $repository;
    protected StatisticsService $service;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(VisitRepository::class);
        $this->service = new StatisticsService();
    }

    public function test_Index(): void
    {
        $response = $this->service->index();
        $this->assertInstanceOf(\Inertia\Response::class, $response);
    }

    public function test_Get(): void
    {
        $response = $this->service->get(Carbon::now()->subMonth(), Carbon::now());
        $this->assertIsArray($response);
    }
}
