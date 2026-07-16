<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

test('forgot password page can be rendered', function () {
    $response = $this->get(route('password.request'));

    $response->assertStatus(200);
    $response->assertSee('Forgot Password?');
});

test('reset link email is sent successfully for valid user', function () {
    $user = User::factory()->create([
        'email' => 'staff_user@example.com',
        'status' => 1,
    ]);

    $response = $this->post(route('password.email'), [
        'email' => 'staff_user@example.com',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('status');
});

test('reset link generation fails for nonexistent email', function () {
    $response = $this->post(route('password.email'), [
        'email' => 'nonexistent@example.com',
    ]);

    $response->assertSessionHasErrors('email');
});

test('reset password view renders with valid token', function () {
    $token = 'sample-reset-token';
    $email = 'staff_user@example.com';

    $response = $this->get(route('password.reset', [
        'token' => $token,
        'email' => $email,
    ]));

    $response->assertStatus(200);
    $response->assertSee('Reset Password');
    $response->assertSee($token);
    $response->assertSee($email);
});

test('password can be successfully reset', function () {
    Event::fake();

    $user = User::factory()->create([
        'email' => 'staff_user@example.com',
        'password' => Hash::make('oldpassword'),
        'status' => 1,
    ]);

    $token = Password::broker()->createToken($user);

    $response = $this->post(route('password.update'), [
        'token' => $token,
        'email' => 'staff_user@example.com',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('status');

    $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    Event::assertDispatched(PasswordReset::class);
});
