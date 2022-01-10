<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory;

    public function chat_user()
    {
        return $this->belongsTo(chat_user::class);
    }
}
