<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'user';
    public function room()
    {
        return $this->hasMany(RoomModel::class);
    }

    public function user_room()
    {
        return $this->hasMany(UserRoomModel::class, 'id', 'user_id');
    }
}
