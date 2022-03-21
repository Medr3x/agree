<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'users_cards';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'card_id',
        'created_by',
		'updated_by'
    ];
}
