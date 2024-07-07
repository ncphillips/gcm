<?php

namespace Tests\Aggregates;

use App\Aggregates\UserAggregate;
use App\StorableEvents\UserCreated;
use App\StorableEvents\UserNameChanged;
use App\StorableEvents\UserPasswordChanged;
use Illuminate\Support\Str;

test('creating a user', function () {
    $uuid = (string)Str::uuid();
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

    UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: 'John Doe', passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->changePassword('new-password-hash'))
        ->assertRecorded(new UserPasswordChanged(passwordHash: 'new-password-hash', changedByUserUuid: $uuid));
});

test("another user can set a user's password", function () {
    $uuid = (string)Str::uuid();
    $anotherUuid = (string)Str::uuid();

    UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: 'John Doe', passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->changePassword('new-password-hash', changedByUserUuid: $anotherUuid))
        ->assertRecorded(new UserPasswordChanged(passwordHash: 'new-password-hash', changedByUserUuid: $anotherUuid));
});

test("a user can change their own name", function () {
    $uuid = (string)Str::uuid();

    /** @var UserAggregate $user */
    $user = UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: 'John Doe', passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->setName(name: 'Jane Doe'))
        ->assertRecorded(new UserNameChanged(name: 'Jane Doe', changedByUserUuid: $uuid))
        ->aggregateRoot();

    expect($user->name)->toBe('Jane Doe');
});