<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyLimit extends Model
{
    use Uuids, HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = ([

        'user_id',
        'foodproperty_id',
        'value',
        'status',

    ]);

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function foodproperties(){
        return $this->belongsTo(FoodProperties::class,'foodproperty_id');
    }
}
