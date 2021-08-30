<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $gurarded = ['id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'purchases', 'user_id', 'product_id')
            ->as('purchase')
            ->withPivot('transaction_id', 'status', 'amount')
            ->withTimestamps();
    }
}
