<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\User\Entities\UserEntity;
use App\Domain\User\Mappers\UserMapper;
use App\Domain\User\Repositories\UserInterface;
use App\Models\User as UserModel;

class UserRepository implements UserInterface
{
    public function fetchAllUsers(): array
    {
        $models = UserModel::all();
        return $models->map(fn(UserModel $model) => UserMapper::toEntity($model))->all();
    }

    public function findByEmail(string $email): ?UserModel
    {
        return UserModel::where('email', '=', $email)->first();
    }

    public function store(array $data): ?UserEntity
    {
        $model = UserModel::create($data);
        return $model ? UserMapper::toEntity($model) : null;
    }

    public function fetchUserById(int $userId): ?UserEntity
    {
        $model = UserModel::where('id', '=', $userId)->first();
        return $model ? UserMapper::toEntity($model) : null;
    }

    public function update(array $data, int $userId): ?UserEntity
    {
        $model = UserModel::where('id', '=', $userId)->first();

       return $model
        ? UserMapper::toEntity(tap($model)->update($data) ? $model : $model)
        : null;

    }

    public function delete(int $userId)
    {
        return UserModel::destroy($userId);
    }
}
