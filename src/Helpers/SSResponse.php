<?php

namespace Konnco\SatSet\Helpers;

use Illuminate\Support\Facades\Response;

class SSResponse
{
    private int $code = 200;

    private string|array $content = '';

    private array $headers = [];

    public static function make(): self
    {
        return new self;
    }

    public static function success(string|array $content = '', array $headers = [], $forceSend = false): \Illuminate\Http\Response
    {
        return (new self)
            ->content($content)
            ->headers($headers)
            ->send();
    }

    public static function error($message = '', string|array $content = '', $code = 500, $headers = []): \Illuminate\Http\Response
    {
        return (new self)
            ->content([
                'errors' => $content,
                'message' => $message,
            ])
            ->code($code)
            ->headers($headers)
            ->send();
    }

    public static function validationFailed(\Closure $errorBagClosure, string $message = null): \Illuminate\Http\Response
    {
        $messageBag = new SSResponseMessageBag();
        $errors = $errorBagClosure($messageBag);

        return self::error(
            message: $message ?? collect($errors)?->flatten()?->first(),
            content: $errors->toArray(),
            code: 422)
            ->send();
    }

    public function content(string|array $content = ''): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): array
    {
        return [
            'data' => $this->content,
        ];
    }

    public function code($code = 200): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function headers(array $headers = []): static
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeader(): array
    {
        return $this->headers;
    }

    public function send(): \Illuminate\Http\Response
    {
        return Response::make(
            $this->getContent(),
            $this->getCode()
        );
    }
}
