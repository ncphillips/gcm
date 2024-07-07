<?php

namespace Tests\Aggregates;

use App\Aggregates\UserAggregate;
use App\StorableEvents\UserCreated;
use App\StorableEvents\UserEmailChanged;
use App\StorableEvents\UserEmailVerified;
use App\StorableEvents\UserNameChanged;
use App\StorableEvents\UserPasswordChanged;
use Carbon\CarbonImmutable;
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
    expect($user->email_verified_at)->toBeNull();
});

test("users can set their own password", function () {
    $uuid = (string)Str::uuid();

    UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: 'John Doe', passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->changePassword('new-password-hash'))
        ->assertRecorded(new UserPasswordChanged(passwordHash: 'new-password-hash', changedByUserUuid: $uuid));
});

test("another user can change someones password", function () {
    $uuid = (string)Str::uuid();
    $anotherUuid = (string)Str::uuid();

    UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: 'John Doe', passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->changePassword('new-password-hash', changedByUserUuid: $anotherUuid))
        ->assertRecorded(new UserPasswordChanged(passwordHash: 'new-password-hash', changedByUserUuid: $anotherUuid));
});

/**
 * Changing Names
 */
test("a user can change their own name", function () {
    $uuid = (string)Str::uuid();
    $oldName = 'John Doe';
    $newName = 'Jane Doe';

    /** @var UserAggregate $user */
    $user = UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: $oldName, passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->setName(name: $newName))
        ->assertRecorded(new UserNameChanged(name: $newName, changedByUserUuid: $uuid))
        ->aggregateRoot();

    expect($user->name)->toBe($newName);
});

test("another user can change someone's name", function () {
    $uuid = (string)Str::uuid();
    $anotherUuid = (string)Str::uuid();
    $oldName = 'John Doe';
    $newName = 'Jane Doe';

    /** @var UserAggregate $user */
    $user = UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: $oldName, passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->setName(name: $newName, changedByUserUuid: $anotherUuid))
        ->assertRecorded(new UserNameChanged(name: $newName, changedByUserUuid: $anotherUuid))
        ->aggregateRoot();

    expect($user->name)->toBe($newName);
});

test('a user sets their name, but it does not change', function () {
    $uuid = (string)Str::uuid();
    $name = 'John Doe';

    /** @var UserAggregate $user */
    $user = UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: $name, passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->setName(name: $name))
        ->assertNothingRecorded()
        ->aggregateRoot();

    expect($user->name)->toBe($name);
});

/**
 * Verifying Email
 */

test('a user can verify their', function () {
    $uuid = (string)Str::uuid();

    /** @var UserAggregate $user */
    $user = UserAggregate::fake($uuid)
        ->given([new UserCreated(email: 'test@example.com', name: 'John Doe', passwordHash: 'password-hash')])
        ->when(fn(UserAggregate $user) => $user->verifyEmail())
        ->assertRecorded(new UserEmailVerified())
        ->aggregateRoot();

    expect($user->email_verified_at)->toBeInstanceOf(CarbonImmutable::class);
});

/**
 * Changing Emails
 */
test("a user can change their own email", function () {
    $uuid = (string)Str::uuid();
    $oldEmail = 'test@example.com';
    $newEmail = 'cool@example.com';

    /** @var UserAggregate $user */
    $user = UserAggregate::fake($uuid)
        ->given([
            new UserCreated(email: $oldEmail, name: 'John Doe', passwordHash: 'password-hash'),
            new UserEmailVerified(),
        ])
        ->when(fn(UserAggregate $user) => $user->setEmail(email: $newEmail))
        ->assertRecorded(new UserEmailChanged(email: $newEmail, changedByUserUuid: $uuid))
        ->aggregateRoot();

    expect($user->name)->toBe('John Doe')
        ->and($user->email)->toBe($newEmail)
        ->and($user->email_verified_at)->toBeNull();
});

test("another user can change someone's email", function () {
    $uuid = (string)Str::uuid();
    $anotherUuid = (string)Str::uuid();
    $oldEmail = 'test@example.com';
    $newEmail = 'cool@example.com';

    /** @var UserAggregate $user */
    $user = UserAggregate::fake($uuid)
        ->given([
            new UserCreated(email: $oldEmail, name: 'John Dorian', passwordHash: 'password-hash'),
            new UserEmailVerified(),
        ])
        ->when(fn(UserAggregate $user) => $user->setEmail(email: $newEmail, changedByUserUuid: $anotherUuid))
        ->assertRecorded(new UserEmailChanged(email: $newEmail, changedByUserUuid: $anotherUuid))
        ->aggregateRoot();

    expect($user->name)->toBe('John Dorian')
        ->and($user->email)->toBe($newEmail)
        ->and($user->email_verified_at)->toBeNull();
});

test('a user sets their email, but it does not change', function () {
    $uuid = (string)Str::uuid();
    $email = 'test@banana.com';

    /** @var UserAggregate $user */
    $user = UserAggregate::fake($uuid)
        ->given([
            new UserCreated(email: $email, name: 'Gregory Face', passwordHash: 'password-hash'),
            new UserEmailVerified(),
        ])
        ->when(fn(UserAggregate $user) => $user->setEmail(email: $email))
        ->assertNothingRecorded()
        ->aggregateRoot();

    expect($user->name)->toBe('Gregory Face')
        ->and($user->email)->toBe($email)
        ->and($user->email_verified_at)->not()->toBeNull();
});