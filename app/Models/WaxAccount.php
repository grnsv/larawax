<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaxAccount extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'pub_keys',
    ];

    protected function casts(): array
    {
        return [
            'pub_keys' => AsCollection::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
