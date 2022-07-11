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

    protected $table = 'daily_limits';

    protected $fillable = ([

        'user_id',
        'vitamin_a',
        'vitamin_c',
        'vitamin_d',
        'vitamin_e',
        'salt',
        'sugar',
        'fat',
        'protein',
        'calorie',
        'status',

    ]);

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function foodproperties(){
        return $this->belongsTo(FoodProperties::class,'foodproperty_id');
    }
}
