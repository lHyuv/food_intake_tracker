<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserIssues extends Model
{
    use Uuids, HasFactory, SoftDeletes;
    
    protected $guarded = ['id'];
    
    protected $fillable = ([
        'user_id',
        'healthissue_id',
        'status',
    
    ]);
}