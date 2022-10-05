<?php

namespace Konnco\SatSet\Http\Controllers\Auth\Login\Concerns;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Konnco\SatSet\Minions\Support\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait CanLoggedInUser
{
    /**
     * @return Builder|Model|null
     */
    public function getUserFromDatabase(): null|Builder|Model
    {
        return $this->modelQuery()
            ->where(function ($query) {
                foreach ($this->columnIdentifierMap() as $column => $field) {
                    $query->orWhere($column, $field);
                }
            })->first();
    }

    /**
     * @param Model|Builder|null $user
     * @return void
     */
    public function cacheUserIntoClassVariable(Model|Builder|null $user): void
    {
        $this->user = $user;
    }

    /**
     * @param Model|Builder|null $user
     * @return void
     */
    public function triggerLoggedInEvent(Model|Builder|null $user): void
    {
        $this->didLoggedIn($user);
    }

    /**
     * @param Model|Builder|null $user
     * @return void
     *
     * @throws Exception
     */
    public function ensureUserHasImplementSanctumInModel(Model|Builder|null $user): void
    {
        if (!method_exists($user, 'createToken')) {
            throw new Exception("Your User model not use \"Laravel\Sanctum\HasApiTokens\" Traits");
        }
    }

    /**
     * @param Model|Builder|null $user
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function ensureUserPasswordIsCorrect(Model|Builder|null $user): void
    {
        if (!Hash::check(\request()->get('password'), @$user->password)) {
            Response::validationFailed(function (\Illuminate\Support\MessageBag $errorBag) {
                $errorBag->add('email', trans('satset::login.invalid_credential'));
            });
        }
    }

    /**
     * @param Model|Builder|null $user
     * @return void
     */
    public function ensureUserIsExistInDatabase(Model|Builder|null $user): void
    {
        if ($user == null) {
            Response::validationFailed(function (\Illuminate\Support\MessageBag $errorBag) {
                $errorBag->add('email', trans('satset::login.user_not_found'));
            });
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    protected function user(): Model
    {
        if ($this->user) {
            return $this->user;
        }

        $user = $this->getUserFromDatabase();

        $this->ensureUserIsExistInDatabase($user);

        $this->ensureUserPasswordIsCorrect($user);

        $this->ensureUserHasImplementSanctumInModel($user);

        $this->triggerLoggedInEvent($user);

        $this->cacheUserIntoClassVariable($user);

        return $user;
    }
}
