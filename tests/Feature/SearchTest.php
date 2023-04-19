<?php

namespace Tests\Feature;

use Tests\TestCase;

class SearchTest extends TestCase
{

    public function test_the_search_page_returns_a_successful_response(): void
    {
        $response = $this->get('/search');

        $response->assertStatus(200);
        $response->assertSeeText('Excel Search Engine');
    }

    public function test_post_search_page_returns_a_successful_response(): void
    {
        $response = $this->post('/search', [
            'ram' => [32],
            'harddiskType' => 'SSD'
        ]);

        $response->assertStatus(200);
        $response->assertSeeText('Excel Search Engine');
        $response->assertSeeText('Model');
        $this->assertCount(8, $response->viewData('serverList'));
    }

    public function test_search_post_page_with_invalid_ram_should_return_error(): void
    {
        $response = $this->post('/search', [
            'ram' => [40]
        ]);

        $response->assertSessionHasErrors(['ram.*']);
        $response->assertStatus(302);
    }

    public function test_search_post_page_with_invalid_filters_should_return_error(): void
    {
        $response = $this->post('/search', [
            'storageFrom' => '5TB',
            'storageTo' => '72TB',
            'harddiskType' => 'MMD',
            'location' => 'test'
        ]);

        $response->assertSessionHasErrors(['storageFrom']);
        $response->assertSessionHasErrors(['harddiskType']);
        $response->assertSessionHasErrors(['location']);
        $response->assertStatus(302);
    }
}
