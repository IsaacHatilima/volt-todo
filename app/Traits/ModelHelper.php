<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ModelHelper
{
    public static function bootModelHelper(): void
    {
        static::creating(function ($model) {
            $model->public_id = Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'public_id';
    }
}
