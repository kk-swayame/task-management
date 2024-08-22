<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'deadline',
        'status',
        'document',
        'assignee_to',
        'user_id',
        'flag',
    ];

    public function assign()
    {
        return $this->belongsTo(User::class , 'assignee_to');
    }
}
