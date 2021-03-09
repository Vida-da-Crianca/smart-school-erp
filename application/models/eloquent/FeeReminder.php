<?php


use \Illuminate\Database\Eloquent\Model as Eloquent;

class FeeReminder extends  Eloquent
{

    protected $table = 'fees_reminder';
   

    const BANK_TYPE_AFTER = 'after_bank';


    // public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
        'reminder_type',
        'day',
        'is_active',
        'created_at',
    ];


    public function scopeIsBankAfter($query)
    {
        return $query->where('reminder_type', self::BANK_TYPE_AFTER);
    }
    public function scopeIsActive($query)
    {
        return $query->where('is_active', 1);
    }
}
