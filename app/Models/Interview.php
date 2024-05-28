<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function candidate():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
