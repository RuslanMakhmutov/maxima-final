<?php

namespace Tests\Feature\Pollution;
use App\DTO\airDTO;
use App\Models\Pollution;
use App\Repositories\PollutionRepository;
use App\Services\PollutionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class PollutionServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(PollutionRepository::class);
        $this->service = new PollutionService($this->repository);
    }

    public function test_saveAirResponse(): void
    {
        $pollution = new Pollution();
        $this->repository
            ->expects($this->once())
            ->method('createItemFromAir')
            ->willReturn($pollution);

        $air = new airDTO(
            (object) [
                'lon' => 1,
                'lat' => 1
            ],
            [
                (object) [
                    'dt' => now()->timestamp,
                ]
            ]
        );

        $result = $this->service->saveAirResponse($air);
        $this->assertNotEmpty($result, 'The result should not be empty.');
        $this->assertInstanceOf(Pollution::class, $result, 'The result should be an instance of Pollution.');
    }
}
