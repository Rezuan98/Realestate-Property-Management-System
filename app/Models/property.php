<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type(){
        return $this->belongsTo(propertyType::class,'ptype_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'agent_id','id');
    }
}
