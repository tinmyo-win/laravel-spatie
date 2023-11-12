<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserQueryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function admin_can_fetch_all_users()
    {
        $email = 'mgmg@g.com';
        $authUser = User::factory(['email' => $email])->create();

        $role = Role::where('name', 'admin')->first();
        $authUser->assignRole($role);

        $token = $this->getToken();

        $users = $this->get('api/users', [
            'Authorization' => "Bearer $token",
        ]);

        $actualUsersCount = User::count();

        $this->assertCount($actualUsersCount, $users->json());
    }

    /** @test */
    public function normal_user_will_be_forbidden_to_fetch_users()
    {
        $email = 'mgmg@g.com';
        User::factory(['email' => $email])->create();

        $token = $this->getToken();

        $result = $this->get('api/users', [
            'Authorization' => "Bearer $token",
        ]);

        $this->assertEquals('You do not have permission for this request!', $result['message']);
    }
}
