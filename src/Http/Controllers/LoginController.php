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

class LoginController extends Controller
{
    use Concerns\HasRequestValidation;
    use Concerns\Login\HasLifecycleEvent;

    protected string $model;

    private function model(): string|Model
    {
        return $this->model ?? '\\App\\Models\\User';
    }

    public function modelQuery(): Builder
    {
        return $this->model()::query();
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
     * @return Response
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $this->validateRequest();
        $user = $this->user();

        if ($user instanceof Response) {
            return $user;
        }

        $token = $user->createToken($this->requestDevice());

        return SSResponse::success($token->plainTextToken);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    protected function user(): Response|Model
    {
        $user = $this->modelQuery()
            ->where(function ($query) {
                foreach ($this->columnIdentifierMap() as $column => $field) {
                    $query->orWhere($column, $field);
                }
            })->first();

        if ($user == null) {
            return SSResponse::validationFailed(function (SSResponseMessageBag $errorBag) {
                $errorBag->add(field: 'email', message: 'Akun tidak ditemukan');

                return $errorBag;
            });
        }

        if (! Hash::check(\request()->get('password'), @$user->password)) {
            return SSResponse::validationFailed(function (SSResponseMessageBag $errorBag) {
                $errorBag->add(field: 'email', message: 'Email atau password tidak valid silahkan coba lagi');

                return $errorBag;
            });
        }

        if (! method_exists($user, 'createToken')) {
            throw new Exception("Your User model not use \"Laravel\Sanctum\HasApiTokens\" Traits");
        }

        $this->didLoggedIn($user);

        return $user;
    }
}
