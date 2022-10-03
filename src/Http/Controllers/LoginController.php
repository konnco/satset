<?php

namespace Konnco\SatSet\Http\Controllers;

use Exception;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Konnco\SatSet\Helpers\SSResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LoginController extends Controller
{
    use Concerns\HasRequestValidation;

    protected string $model;

    private function getModel(): string|Model
    {
        return $this->model ?? "\\App\\Models\\User";
    }

    public function getQuery(): Builder
    {
        return $this->getModel()::query();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRequestDevice(): mixed
    {
        return request()->get('device', 'Default');
    }

    public function getLoginColumnIdentifier(): array
    {
        return [
            'email' => 'email'
        ];
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        $this->validate();
        $user = $this->getIdentifiedUser();
        $token = $user->createToken($this->getRequestDevice());

        return SSResponse::success($token->plainTextToken);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    protected function getIdentifiedUser(): Model|null
    {
        $user = $this->getQuery()
            ->where(function ($query) {
                foreach ($this->getLoginColumnIdentifier() as $column => $field) {
                    $query->orWhere($column, $field);
                }
            })->first();

        if ($user == null) {
            SSResponse::validationFailed(function ($errorBag) {
                $errorBag->error(field: 'email', error: 'Akun tidak ditemukan');
            }, message: "Hello");
        }

        if (!Hash::check(\request()->get('password'), @$user->password)) {
            SSResponse::validationFailed(function ($errorBag) {
                $errorBag->error(field: 'email', error: 'Email atau password tidak valid silahkan coba lagi');
            }, message: "Hello");
        }

        if (!method_exists($user, 'createToken')) {
            throw new Exception("Your User model not use \"Laravel\Sanctum\HasApiTokens\" Traits");
        }

        return $user;
    }
}
