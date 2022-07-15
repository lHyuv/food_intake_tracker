<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intake extends Model
{
    use Uuids, HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'intakes';

    protected $fillable = ([
        'user_id',
        'food_id',
        'serving',
        'ext_food_id',
        'ext_food_name',
        'type',
        'status',
        //
        'ext_vitamin_a',
        'ext_vitamin_c',
        'ext_vitamin_d',
        'ext_vitamin_e',
        'ext_fat',
        'ext_protein',
        'ext_salt',
        'ext_sugar',

    ]);

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function foods(){
        return $this->belongsTo(Food::class,'food_id');
    }
}
