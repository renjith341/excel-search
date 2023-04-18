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
}
