<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientMessages extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'email',
        'contact',
        'message',
        'read_status'
    ];
}
