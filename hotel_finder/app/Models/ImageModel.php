<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    use HasFactory;
    protected $table = 'image';

    public function room()
    {
        return $this->belongsTo(RoomModel::class, 'room_id', 'id');
    }
}
