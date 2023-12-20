<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'donations';
    protected $fillable = ['title', 'description', 'image', 'donation_target', 'start_date', 'end_date'];

    public function getTotalDonationAmount()
    {
        return $this->transactions()->where('status', 'Paid')->sum('donation_amount');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'donation_id');
    }
}
