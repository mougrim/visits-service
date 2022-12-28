<?php

declare(strict_types=1);

namespace Mougrim\VisitsService\Action;

use JsonSerializable;

class ActionPayload implements JsonSerializable
{
    public function __construct(
        private readonly array|object|null $data = null,
        private readonly ?ActionError $error = null
    ) {
    }

    public function getData(): array|object|null
    {
        return $this->data;
    }

    public function getError(): ?ActionError
    {
        return $this->error;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        $payload = [];

        if ($this->data !== null) {
            $payload = $this->data;
        } elseif ($this->error !== null) {
            $payload = [
                'code' => 'error',
                'error' => $this->error,
            ];
        }

        return $payload;
    }
}
