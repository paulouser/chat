<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat_user extends Model
{
    use HasFactory;

//    protected $table = 'chat_user';

    public function messages()
    {
        return $this->hasMany(message::class);
    }
}
