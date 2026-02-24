<?php

namespace App\Data;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseDTO
{
    public static function fromRequest(FormRequest $request): static
    {
        $data = $request->validated();

        return static::fromArray($data);
    }

    public static function fromArray(array $data): static
    {
        return new static(...$data);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
