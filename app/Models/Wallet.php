<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    protected $fillable = ["name", "balance", "currency", "user_id", "receiver_wallet_id"];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
