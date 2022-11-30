<?php

namespace App\Http;

use App\Exceptions\AppException;
use App\Helpers\Mappers\MongoMapper;
use Illuminate\Auth\EloquentUserProvider;

class MongoUserProvider extends EloquentUserProvider
{
    public function createModel()
    {
        $class = '\\' . ltrim($this->model, '\\');

        return new $class;
    }

    /**
     * @throws AppException
     */
    public function retrieveById($identifier)
    {
        $model = $this->createModel();

        return $this->newModelQuery($model)
            ->where($model->getAuthIdentifierName(), MongoMapper::toMongoUuid($identifier))
            ->first();
    }

//    public function retrieveByCredentials(array $credentials)
//    {
//        if (!isset($credentials['email'])) {
//            return null;
//        }
//
//        return User::query()->where('email', '=', $credentials['email'])->first();
//    }
//
//    public function validateCredentials(UserContract $user, array $credentials): bool
//    {
//        return Hash::check($credentials['password'], $user->getAuthPassword());
//    }
}
