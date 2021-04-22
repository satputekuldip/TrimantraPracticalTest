<?php namespace Tests\Repositories;

use App\Models\EventImage;
use App\Repositories\EventImageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EventImageRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EventImageRepository
     */
    protected $eventImageRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->eventImageRepo = \App::make(EventImageRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_event_image()
    {
        $eventImage = EventImage::factory()->make()->toArray();

        $createdEventImage = $this->eventImageRepo->create($eventImage);

        $createdEventImage = $createdEventImage->toArray();
        $this->assertArrayHasKey('id', $createdEventImage);
        $this->assertNotNull($createdEventImage['id'], 'Created EventImage must have id specified');
        $this->assertNotNull(EventImage::find($createdEventImage['id']), 'EventImage with given id must be in DB');
        $this->assertModelData($eventImage, $createdEventImage);
    }

    /**
     * @test read
     */
    public function test_read_event_image()
    {
        $eventImage = EventImage::factory()->create();

        $dbEventImage = $this->eventImageRepo->find($eventImage->id);

        $dbEventImage = $dbEventImage->toArray();
        $this->assertModelData($eventImage->toArray(), $dbEventImage);
    }

    /**
     * @test update
     */
    public function test_update_event_image()
    {
        $eventImage = EventImage::factory()->create();
        $fakeEventImage = EventImage::factory()->make()->toArray();

        $updatedEventImage = $this->eventImageRepo->update($fakeEventImage, $eventImage->id);

        $this->assertModelData($fakeEventImage, $updatedEventImage->toArray());
        $dbEventImage = $this->eventImageRepo->find($eventImage->id);
        $this->assertModelData($fakeEventImage, $dbEventImage->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_event_image()
    {
        $eventImage = EventImage::factory()->create();

        $resp = $this->eventImageRepo->delete($eventImage->id);

        $this->assertTrue($resp);
        $this->assertNull(EventImage::find($eventImage->id), 'EventImage should not exist in DB');
    }
}
