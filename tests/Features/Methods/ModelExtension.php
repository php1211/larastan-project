<?php

declare(strict_types=1);

namespace Tests\Features\Methods;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ModelExtension
{
    /**
     * @return iterable<\App\User>|\Illuminate\Database\Eloquent\Collection
     */
    public function testAll()
    {
        return User::all();
    }

    public function testReturnThis(): Builder
    {
        $user = User::join('tickets.tickets', 'tickets.tickets.id', '=', 'tickets.sale_ticket.ticket_id')
            ->where(['foo' => 'bar']);

        return $user;
    }

    public function testWhere(): Builder
    {
        return (new Thread)->where(['foo' => 'bar']);
    }

    public function testStaticWhere(): Builder
    {
        return Thread::where(['foo' => 'bar']);
    }

    public function testDynamicWhere(): Builder
    {
        return (new Thread)->whereFoo(['bar']);
    }

    public function testStaticDynamicWhere(): Builder
    {
        return Thread::whereFoo(['bar']);
    }

    public function testIncrement() : int
    {
        /** @var User $user */
        $user = new User;
        return $user->increment('counter');
    }

    public function testDecrement() : int
    {
        /** @var User $user */
        $user = new User;

        return $user->decrement('counter');
    }

    public function testFind() : User
    {
        return User::find(1);
    }

    public function testFindCanReturnCollection() : Collection
    {
        /** @var Collection $users */
        $users = User::find([1, 2, 3]);

        return $users;
    }

    /** @return iterable<User>|null */
    public function testFindCanReturnCollectionWithAnnotation()
    {
        return User::find([1, 2, 3]);
    }

    /** @return iterable<User> */
    public function testFindMany()
    {
        return User::findMany([1, 2, 3]);
    }

    public function testFindOrFail() : User
    {
        return User::findOrFail(1);
    }

    public function testFindOrFailCanReturnCollection() : Collection
    {
        /** @var Collection $users */
        $users = User::findOrFail([1, 2, 3]);

        return $users;
    }
}

class Thread extends Model
{
}
