<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'title', 'description', 'category',
        'budget', 'bid_deadline', 'status', 'winning_bid_id',
    ];

    protected $casts = [
        'bid_deadline' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function winningBid()
    {
        return $this->belongsTo(Bid::class, 'winning_bid_id');
    }
}