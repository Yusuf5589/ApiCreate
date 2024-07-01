<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserLog extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'user';
    protected $fillable = ["username", "password", "created_at", "updated_at"];
}
