<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use Uuids, HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'foods';

    protected $fillable = ([
        'food_name',
        'status',
    ]);

    public function foodproperties(){
        return $this->hasOne('App\Models\FoodProperties');
    }
}
