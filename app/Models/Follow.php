<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    // Define the relationship to get the user who is doing the following
    public function userDoingTheFollowing()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship to get the user who is being followed
    public function userBeingFollowed()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}
