<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\EventImage;

class EventImageApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_event_image()
    {
        $eventImage = EventImage::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/event_images', $eventImage
        );

        $this->assertApiResponse($eventImage);
    }

    /**
     * @test
     */
    public function test_read_event_image()
    {
        $eventImage = EventImage::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/event_images/'.$eventImage->id
        );

        $this->assertApiResponse($eventImage->toArray());
    }

    /**
     * @test
     */
    public function test_update_event_image()
    {
        $eventImage = EventImage::factory()->create();
        $editedEventImage = EventImage::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/event_images/'.$eventImage->id,
            $editedEventImage
        );

        $this->assertApiResponse($editedEventImage);
    }

    /**
     * @test
     */
    public function test_delete_event_image()
    {
        $eventImage = EventImage::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/event_images/'.$eventImage->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/event_images/'.$eventImage->id
        );

        $this->response->assertStatus(404);
    }
}
