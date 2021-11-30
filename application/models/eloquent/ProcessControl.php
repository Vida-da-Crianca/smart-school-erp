<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class ProcessControl extends Eloquent {


    protected $table = 'schedule_controls';

    protected $fillable = [
        'status',
        'timeout',
        'name'
       
    ];
}