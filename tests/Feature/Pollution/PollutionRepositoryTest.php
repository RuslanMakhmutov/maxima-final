<?php

namespace Tests\Feature\Pollution;
use App\DTO\airDTO;
use App\Models\Pollution;
use App\Repositories\PollutionRepository;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PollutionRepositoryTest extends TestCase
{
    // use RefreshDatabase;

    protected Pollution $model;
    protected PollutionRepository $repository;
    protected airDTO $air;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = $this->createMock(Pollution::class);
        $this->repository = new PollutionRepository($this->model);

        $this->air = new airDTO(
            (object) [
                'lon' => 99.99,
                'lat' => 77.77,
            ],
            [
                (object) [
                    'dt' => 7777777777,
                    'main' => (object) [
                        'aqi' => 1
                    ],
                    'components' => (object) [
                        'no2' => 1,
                        'o3' => 1,
                        'so2' => 1,
                        'pm2_5' => 1,
                    ],
                ]
            ]
        );
    }

    public function test_getIdForAir(): void
    {
        $expectedId = "77.77_99.99_7777777777";

        $result = $this->repository->getIdForAir($this->air);

        $this->assertEquals($expectedId, $result);
    }

    public function test_getItemByAir(): void
    {
        $queryBuilderMock = $this->createMock(\MongoDB\Laravel\Eloquent\Builder::class);

        $this->model
            ->expects($this->once())
            ->method('newQuery')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $result = $this->repository->getItemByAir($this->air);

        $this->assertNull($result, 'The result should be null.');
    }

    public function test_createItemFromAir(): void
    {
        $queryBuilderMock = $this->createMock(\MongoDB\Laravel\Eloquent\Builder::class);

        $this->model
            ->expects($this->once())
            ->method('newQuery')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock
            ->expects($this->once())
            ->method('make')
            ->willReturn($this->model);

        $this->model
            ->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $result = $this->repository->createItemFromAir($this->air);

        $this->assertInstanceOf(Pollution::class, $result, 'The result should be an instance of Pollution.');
    }
}
