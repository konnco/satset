<?php

namespace Konnco\SatSet\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Konnco\SatSet\Minions\Support\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class LoginController extends Controller
{
    use Concerns\Login\Concerns\HasRequestValidation;
    use Concerns\Login\Concerns\Login\HasEvent;
    use Concerns\Login\Concerns\CanRegisterPushNotificationToken;
    use Concerns\Login\Concerns\CanLoggedInUser;

    protected string $model;

    protected ?Model $user = null;

    private function model(): string
    {
        return $this->model ?? config('satset.auth.model');
    }

    public function modelQuery(): Builder
    {
        /**
         * @var Model $model
         */
        $model = $this->model();

        return $model::query();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function requestDevice(): mixed
    {
        return request()->get('device', 'Default');
    }

    public function columnIdentifier(): array
    {
        return [
            'email' => 'email',
        ];
    }

    public function columnIdentifierMap()
    {
        return collect($this->columnIdentifier())->mapWithKeys(fn ($item, $key) => [$key => \request()->get($item)]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function __invoke(Request $request)
    {
        $this->validateRequest();
        $user = $this->user();

        $token = $user->createToken($this->requestDevice());

        $this->registerPushNotification();

        return Response::success($token->plainTextToken);
    }
}
