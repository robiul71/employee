<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    use HasFactory;
    protected $dates=['date'];
    protected $times=['clock_in','clock_out'];
    protected $guarded=[];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
