<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'transactions';
    protected $fillable = [
        'donation_id',
        'user_id',
        'status',
        'donation_amount',
        'message',
        'snap_token',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
