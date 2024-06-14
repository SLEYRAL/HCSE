<?php


use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiCommentTest extends TestCase
{
    public function test_admin_Store_Comment()
    {
        $admin = Administrator::factory()->create();
        $profile = Profile::factory()->create();

        $store = [
        ];
        // User is not authorize
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson('/api/admin/comment', $store);

        $response->assertStatus(403);
        $response = $this->actingAs($admin)
            ->withSession(['banned' => false])
            ->postJson('/api/admin/comment', $store);
        $response->assertStatus(422);
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('message')
                ->has('errors', fn (AssertableJson $json2) =>
            $json2->has('content')
                ->has('profile_id')
                ->where('content.0', 'The content field is required.')
                ->where('profile_id.0', 'The profile id field is required.')
            ));

        $store  = [
            'content' => 'test content',
            'profile_id' => $profile->id
        ];
        $response = $this->actingAs($admin)
            ->withSession(['banned' => false])
            ->postJson('/api/admin/comment', $store);
        $response->assertStatus(201);
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('id')
                ->has('content')
                ->has('user_id')
                ->has('profile_id')
                ->has('created_at')
                ->has('updated_at')
                ->where('content', $store['content'])
                ->where('profile_id', $store['profile_id'])
                ->where('user_id', $admin->id
                )
            );
        $response = $this->actingAs($admin)
            ->withSession(['banned' => false])
            ->postJson('/api/admin/comment', $store);
        $response->assertStatus(403);
    }
}
