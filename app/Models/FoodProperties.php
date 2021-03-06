<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodProperties extends Model
{
    use Uuids, HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'food_properties';

    protected $fillable = ([
        'property',
        'food_id',
        'amount',
        'status',
    ]);

    public function foods(){
        return $this->belongsTo(Food::class,'food_id');
    }
}
