<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ETicketProcess extends Model
{
    use HasFactory;
    protected $table = 'eticket_processes';
    protected $guarded=[];
}
