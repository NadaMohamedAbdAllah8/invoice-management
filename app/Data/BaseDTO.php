<?php

namespace App\Data;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseDTO
{
    public static function fromRequest(FormRequest $request): static
    {
        $dto = $request->validated();

        return static::fromArray($dto);
    }

    public static function fromArray(array $dto): static
    {
        return new static(...$dto);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
