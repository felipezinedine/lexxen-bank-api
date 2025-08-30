<?php

namespace App\Domain\User\Mappers;

use App\Domain\User\Entities\UserEntity;
use App\Models\User as UserModel;

class UserMapper
{
    public static function toEntity (UserModel $model): UserEntity
    {
        return new UserEntity (
            $model->id,
            $model->name,
            $model->cpf,
            $model->email,
            $model->status,
        );
    }

    public static function toModel (UserEntity $entity): UserModel
    {
        $model = new UserModel();
        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->cpf = $entity->cpf;
        $model->email = $entity->email;
        $model->status = $entity->status;

        return $model;
    }
}
