<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'project_id', 'developer_id', 'price',
        'duration_days', 'proposal', 'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }
}