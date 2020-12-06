<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public function restaurant()
    {
        return $this->belongsTo(Restorant::class, 'restorants_id');
    }
}
