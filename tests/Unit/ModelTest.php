<?php

namespace Tests\Unit;

use App\Models\Administrator;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */

    public function test_users_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id','name', 'email', 'email_verified_at', 'password', 'is_admin'
            ]), 1);
    }

    public function test_profile_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('profiles', [
                'id','lastname', 'firstname', 'image', 'status', 'user_id', 'created_at', 'updated_at'
            ]), 1);
    }

    public function test_comment_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('comments', [
                'id','content', 'user_id', 'profile_id'
            ]), 1);
    }

    public function test_models_User_CRUD(): void
    {
        $user = User::factory()->create();
        $this->assertModelExists($user);
        $this->assertInstanceOf(User::class,$user);
        $this->assertNotEquals('test@test.com', $user->email);
        $user->update(['email' => 'test@test.com']);
        $this->assertEquals('test@test.com', $user->email);
        $this->assertFalse($user->is_admin);
        $user->delete();
        $this->assertModelMissing($user);
    }

    public function test_models_Administrator_CRUD(): void
    {
        $admin = Administrator::factory()->create();
        $this->assertInstanceOf(Administrator::class,$admin);
        $this->assertModelExists($admin);
        $this->assertTrue($admin->is_admin);
        $admin->delete();
        $this->assertModelMissing($admin);
    }

    public function test_models_Profile_CRUD(): void
    {
        $admin = Administrator::factory()->create();
        $profile= Profile::factory()->create(['user_id' => $admin->id]);
        $this->assertModelExists($profile);
        $this->assertNotEquals('test@test.com', $profile->lastname);
        $profile->update(['lastname' => 'test@test.com']);
        $this->assertEquals('test@test.com', $profile->lastname);
        $admin->delete();
        $this->assertModelMissing($admin);
    }

    public function test_models_Comment_CRUD(): void
    {
        $admin = Administrator::factory()->create();
        $profile= Profile::factory()->create(['user_id' => $admin->id]);
        $comment = Comment::factory()->create(['user_id' => $admin->id, 'profile_id' => $profile->id]);
        $this->assertModelExists($comment);
        $this->assertNotEquals('test@test.com', $comment->content);
        $comment->update(['content' => 'test@test.com']);
        $this->assertEquals('test@test.com', $comment->content);
        $admin->delete();
        $this->assertModelMissing($admin);
    }




}
