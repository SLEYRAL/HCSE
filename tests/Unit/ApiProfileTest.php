<?php

namespace Tests\Unit;

use App\Enum\StatusProfile;
use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiProfileTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

         $this->seed();
    }
    public function test_public_Get_Profile()
    {
        $admin = Administrator::factory()->create();
        $profile = Profile::factory(['status' => 'actif', 'user_id' => $admin->id])->create();
        $response = $this->get('/api/profile');
        $response->assertStatus(200);
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                ->has('data.0', fn (AssertableJson $json2) =>
                    $json2->has('id')
                        ->has('lastname')
                        ->has('firstname')
                        ->has('image')
                        ->has('created_at')
                        ->has('updated_at')
                )
            );
    }

    public function test_admin_Delete_Profile()
    {
        $admin = Administrator::factory()->create();
        $profile = Profile::factory(['status' => 'actif', 'user_id' => $admin->id])->create();

        // User is not authorize
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/api/admin/profile/' . $profile->id);
        $response->assertStatus(403);

        $admin = Administrator::factory()->create();
        $response = $this->actingAs($admin)
            ->withSession(['banned' => false])
            ->delete('/api/admin/profile/' . $profile->id);
        $response->assertStatus(200);
        sleep(1);
        $response = $this->delete('/api/admin/profile/' . $profile->id);
        $response->assertStatus(200);
    }

    public function test_admin_Store_Profile()
    {
        $store = [
            'status' => 'invalid',
        ];

        // User is not authorize
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson('/api/admin/profile', $store);
        $response->assertStatus(403);

        $admin = Administrator::factory()->create();
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($admin)
            ->withSession(['banned' => false])
            ->postJson('/api/admin/profile', $store);
        $response->assertStatus(422);
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('errors', fn (AssertableJson $json2) =>
                $json2->has('image')
                ->has('lastname')
                ->has('firstname')
                    ->where('lastname.0', 'The lastname field is required.')
                    ->where('firstname.0', 'The firstname field is required.')
                    ->where('image.0', 'The image field is required.')
                    ->where('status.0', 'The selected status is invalid.')
                ));
         $store  = [
            'lastname' => 'test lastname',
            'status' => StatusProfile::Inactive,
            'image' => $file,
            'firstname' => 'test FirstName'
        ];
        $response = $this->actingAs($admin)
        ->withSession(['banned' => false])
        ->postJson('/api/admin/profile', $store);
        $response->assertStatus(201);
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('id')
                ->has('lastname')
                ->has('firstname')
                ->has('image')
                ->has('status')
                ->has('user_id')
                ->has('created_at')
                ->has('updated_at')
                ->where('lastname', 'test lastname')
                ->where('firstname', 'test FirstName')
                ->where('status', 'inactif')
            );

    }

    public function test_admin_Update_Profile()
    {
        $admin = Administrator::factory()->create();

        $update = [
            'status' => StatusProfile::Active,
            'lastname' => 'updateName',
            'firstname' => 'updateFirstName'
        ];

        // User is not authorize
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->putJson('/api/admin/profile/2', $update);
        $response->assertStatus(403);

        $response = $this->actingAs($admin)
            ->withSession(['banned' => false])
            ->putJson('/api/admin/profile/2', $update);
        $response->assertStatus(202);
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('id')
                ->has('lastname')
                ->has('firstname')
                ->has('image')
                ->has('status')
                ->has('user_id')
                ->has('created_at')
                ->has('updated_at')
                ->where('lastname', 'updateName')
                ->where('firstname', 'updateFirstName')
                ->where('status', 'actif')
            );
    }
}
