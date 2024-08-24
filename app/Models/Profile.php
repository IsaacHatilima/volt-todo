<?php

namespace App\Models;

use App\Observers\ProfileObserver;
use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ProfileObserver::class])]
class Profile extends Model
{
    use HasFactory, ModelHelper;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $guarded = [
        'id',
        'public_id',
    ];
}
