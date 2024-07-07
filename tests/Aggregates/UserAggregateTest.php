<?php

namespace Tests\Aggregates;

use App\Aggregates\UserAggregate;
use App\StorableEvents\UserCreated;
use App\StorableEvents\UserPasswordChanged;
use Illuminate\Support\Str;

test('creating a user', function () {
    $uuid = (string) Str::uuid();
    $name = 'John Doe';
    $email = 'test@example.com';


    $user = UserAggregate::fake($uuid)
        ->when(fn(UserAggregate $user) => $user->create(name: $name, email: $email, passwordHash: 'password'))
        ->assertRecorded(new UserCreated(email: $email, name: $name, passwordHash: 'password'))
        ->aggregateRoot();

    expect($user->name)->toBe($name);
    expect($user->email)->toBe($email);
});

test("users can set their own password", function () {
    $uuid = (string)Str::uuid();
    $name = 'John Doe';
    $email = 'test@example.com';

    UserAggregate::fake($uuid)
        ->given([new UserCreated(email: $email, name: $name, passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->changePassword('new-password-hash'))
        ->assertRecorded(new UserPasswordChanged(passwordHash: 'new-password-hash', changedByUserUuid: $uuid));
});