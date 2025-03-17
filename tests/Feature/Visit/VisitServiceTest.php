<?php

namespace Tests\Feature\Visit;
use App\Repositories\VisitRepository;
use App\Services\VisitService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class VisitServiceTest extends TestCase
{
    use RefreshDatabase;

    protected VisitRepository $repository;
    protected VisitService $service;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(VisitRepository::class);
        $this->service = new VisitService($this->repository);
    }

    public function test_getVisitableCount(): void
    {
        $expected = 17;
        $this->repository->expects($this->once())->method('getVisitableCount')->willReturn($expected);
        $result = $this->service->getVisitableCount('post', 125);

        $this->assertEquals($expected, $result);
    }
}
