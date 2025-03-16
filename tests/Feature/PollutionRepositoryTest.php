<?php

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

        $this->model = new Pollution();
        $this->repository = new PollutionRepository($this->model);

        $this->air = new airDTO(
            (object) [
                'lon' => 99.99,
                'lat' => 77.77,
            ],
            [
                (object) [
                    'dt' => 7777777777,
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
        $result = $this->repository->getItemByAir($this->air);

        $this->assertNull($result, 'The result should be null.');
    }
}
