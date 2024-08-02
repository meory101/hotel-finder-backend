<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model
{
    use HasFactory;
    protected $table = 'room';
    public function hotel()
    {
        return $this->belongsTo(HotelModel::class, 'hotel_id', 'id');
    }

    public function user()
    {
        return $this->hasMany(UserModel::class);
    }
    public function user_room()
    {
        return $this->hasMany(UserRoomModel::class,'id','room_id');
    }
    public function image()
    {
        return $this->hasMany(ImageModel::class, 'id', 'room_id');
    }
}
