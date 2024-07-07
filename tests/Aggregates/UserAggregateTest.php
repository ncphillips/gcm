<?php

namespace Tests\Aggregates;

use App\Aggregates\UserAggregate;
use App\StorableEvents\UserCreated;
use Illuminate\Support\Str;

test('creating a user', function () {
    $uuid = (string) Str::uuid();
    $name = 'John Doe';
    $email = 'test@example.com';


    $user = UserAggregate::fake($uuid)
        ->when(fn(UserAggregate $user) => $user->create(name: $name, email: $email))
        ->assertRecorded(new UserCreated(email: $email, name: $name))
        ->aggregateRoot();

    expect($user->name)->toBe($name);
    expect($user->email)->toBe($email);
});
