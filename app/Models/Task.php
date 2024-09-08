<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use ModelHelper, HasFactory;

    protected $guarded = [
        'id',
        'public_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function todo(): BelongsTo
    {
        return $this->belongsTo(Todo::class);
    }

    protected function casts(): array
    {
        return [
            'public_id' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
}
