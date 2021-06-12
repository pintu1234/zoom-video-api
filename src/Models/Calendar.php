<?php

namespace Hcbszoom\Zoom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $table='activity';
    protected $fillable = array('user_id','title', 'instructor_name', 'notes', 'startDate','startTime','endTime');

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    public function virtualRoom()
    {
        return $this->hasOne(VirtualRoom::class, 'activity_id', 'id');
    }
}
