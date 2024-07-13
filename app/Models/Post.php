<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title', 'body', 'user_id'
    ];

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
