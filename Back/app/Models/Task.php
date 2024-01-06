<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['taskName', 'taskDate', 'category', 'priority', 'user_id'];

    protected $hidden =  ['user_id'];

}
