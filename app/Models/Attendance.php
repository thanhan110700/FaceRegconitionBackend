<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    const LATE = 1;
    const NOTE_LATE = 0;

    protected $table = 'attendances';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'datetime',
        'period',
        'is_late'
    ];

    protected $appends = ['is_late_label'];

    public function getIsLateLabelAttribute()
    {
        $label = [
            '' => '',
            self::NOTE_LATE => "",
            self::LATE => "Late",
        ];
        return $label[$this->is_late];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
