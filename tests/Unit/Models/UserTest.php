<?php

use App\Models\User;

test('user can be created with factory', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->exists)->toBeTrue();
});

test('user has fillable attributes', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    expect($user->name)->toBe('John Doe')
        ->and($user->email)->toBe('john@example.com');
});

test('user password is hashed', function () {
    $user = User::factory()->create([
        'password' => 'plain-password',
    ]);

    expect($user->password)->not->toBe('plain-password')
        ->and(password_verify('plain-password', $user->password))->toBeTrue();
});

test('user hides sensitive attributes', function () {
    $user = User::factory()->create();

    $array = $user->toArray();

    expect($array)->not->toHaveKey('password')
        ->and($array)->not->toHaveKey('remember_token');
});

test('user casts email_verified_at to datetime', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    expect($user->email_verified_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});
