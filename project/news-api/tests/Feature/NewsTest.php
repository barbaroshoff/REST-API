<?php

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetNews()
    {
        $response = $this->get(route('news.index'));
        $response->assertStatus(200);

        $response = $this->get('/api/v1/abracadabra');
        $response->assertStatus(404);
    }

    public function testCreateNews()
    {
        $response = $this->post(route('news.store'), []);
        $response->assertStatus(422);

        $response = $this->post(route('news.store'), ['title' => 'Sample News', 'content' => 'Lorem ipsum']);
        $response->assertStatus(201);

        $this->refreshDatabase();
    }

    public function testDeleteNews()
    {
        $response = $this->post(route('news.store'), ['title' => 'Sample News', 'content' => 'Lorem ipsum']);
        $response->assertStatus(201);

        $newsId = $this->getFirstNewsId();

        $response = $this->delete(route('news.destroy', ['id' => $newsId]));
        $response->assertStatus(204);

        $response = $this->delete(route('news.destroy', ['id' => $newsId]));
        $response->assertStatus(404);
    }

    public function testGetNewsWithLimitAndOffset()
    {
        factory(News::class, 3)->create();

        $response = $this->get(route('news.index'));
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(count($content['data']), 3);

        $response = $this->get(route('news.index', ['limit' => 1]));
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(count($content['data']), 1);

        $response = $this->get(route('news.index', ['offset' => 1]));
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(count($content['data']), 2);
    }

    private function getFirstNewsId()
    {
        $response = $this->get(route('news.index', ['limit' => 1]));
        $content = json_decode($response->getContent(), true);

        return $content['data'][0]['id'];
    }
}
