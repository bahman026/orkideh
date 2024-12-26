<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function create($data)
    {
        return User::query()->create($data);
    }

    public function update(array $data, $id)
    {
        $user = User::query()->findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete($id): ?bool
    {
        $user = User::query()->findOrFail($id);

        return $user->delete();
    }

    public function all(): Collection
    {
        return User::all();
    }

    public function find($id)
    {
        return User::query()->findOrFail($id);
    }
}
