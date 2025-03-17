<?php

namespace Tests\Feature\Visit;
use App\Models\Visit;
use App\Repositories\VisitRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected Visit $model;
    protected Collection $models;
    protected VisitRepository $repository;
    protected string $testVisitableType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Visit();
        $this->repository = new VisitRepository($this->model);

        $this->testVisitableType = 'unknown';
    }

    public function test_getVisitableCount(): void
    {
        $visit = $this->model->factory()
            ->create([
                'visitable_type' => $this->testVisitableType,
                'visitable_id' => 555,
            ]);
        $this->assertModelExists($visit);

        $result = $this->repository->getVisitableCount($this->testVisitableType, 555);

        $this->assertEquals(1, $result);

        $visit->delete();
    }
}
