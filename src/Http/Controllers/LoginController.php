<?php

namespace Konnco\SatSet\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Konnco\SatSet\Helpers\SSResponse;
use Konnco\SatSet\Helpers\SSResponseMessageBag;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class LoginController extends Controller
{
    use Concerns\HasRequestValidation;
    use Concerns\Login\HasLifecycleEvent;
    use Concerns\CanRegisterPushNotificationToken;
    use Concerns\CanGetLoggedInUser;

    protected string $model;

    protected ?Model $user = null;

    private function model(): string
    {
        return $this->model ?? '\\App\\Models\\User';
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
        return collect($this->columnIdentifier())->mapWithKeys(fn($item, $key) => [$key => \request()->get($item)]);
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception|Throwable
     */
    public function __invoke(Request $request): Response
    {
        $this->validateRequest();
        $user = $this->user();

        $token = $user->createToken($this->requestDevice());

        $this->registerPushNotification();

        return SSResponse::success($token->plainTextToken);
    }
}
