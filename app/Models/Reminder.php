<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminder';
    protected $primaryKey = 'id';

    // A Reminder belongs to Company
    public function company(){
        return $this->belongsTo(Company::class);
    }
}
