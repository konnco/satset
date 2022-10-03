<?php

namespace Konnco\SatSet\Helpers;

class SSResponseMessageBag
{
    protected \Illuminate\Support\Collection $messageBags;

    public function __construct()
    {
        $this->messageBags = collect([]);
    }

    public function error($field, $message): static
    {
        $this->messageBags[$field]->push($message);

        return $this;
    }

    public function toArray(): array
    {
        return $this->messageBags->toArray();
    }
}
