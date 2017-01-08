<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testShow()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', route('users.show', $user->id));

        $this->assertResponseOk();
        $this->assertViewHas('user');
        $this->assertViewHas('posts');
        $this->assertViewHas('comments');
    }

    public function testEdit()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', route('users.edit', $user->id));

        $this->assertResponseOk();
        $this->assertViewHas('user');
    }

    public function testEditFail()
    {
        $user = factory(User::class)->create();
        $anakin = factory(User::class)->create(['name' => 'anakin']);

        $response = $this->actingAs($user)->call('GET', route('users.edit', $anakin->id));

        $this->assertResponseStatus('403');
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $params = [
            'name' => 'Palpatine',
            'email' => 'darthsidious@deathstar.ds'
        ];

        $response = $this->actingAs($user)->call('PATCH', route('users.update', $user->id), $params);

        $this->seeInDatabase('users', $params);
        $this->assertEquals($params['email'], $user->email);
        $this->assertResponseStatus('302');
    }

    public function testUpdatePassword()
    {
        $user = factory(User::class)->create();
        $params = [
            'name' => 'Palpatine',
            'email' => 'darthsidious@deathstar.ds',
            'password' => '7h3_3mp1r3_57r1k35_b4ck',
            'password_confirmation' => '7h3_3mp1r3_57r1k35_b4ck'
        ];

        $response = $this->actingAs($user)->call('PATCH', route('users.update', $user->id), $params);

        $this->assertTrue(Hash::check($params['password'], $user->password));
        $this->assertRedirectedToRoute('users.show', ['id' => $user->id]);
    }

    public function testUpdateFail()
    {
        $user = factory(User::class)->create();
        $anakin = factory(User::class)->create(['name' => 'anakin']);
        $params = [
            'name' => 'Palpatine',
            'email' => 'darthsidious@deathstar.ds'
        ];

        $response = $this->actingAs($user)->call('PATCH', route('users.update', $anakin->id), $params);

        $this->notSeeInDatabase('users', $params);
        $this->assertResponseStatus('403');
    }
}
