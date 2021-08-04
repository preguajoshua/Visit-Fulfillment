<?php

namespace Tests\Unit;

use Tests\TestCase;

class GuestTest extends TestCase
{
    /** @test  */
    public function the_splash_page_can_be_viewed()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
