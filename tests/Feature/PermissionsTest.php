<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    use DatabaseMigrations;

    public function testSimpleUserCannotAccessCategories()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('categories');
        $response->assertStatus(403);
    }

   

}
