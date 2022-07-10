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
        'status',

    ]);

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function foods(){
        return $this->belongsTo(Food::class,'food_id');
    }
}
