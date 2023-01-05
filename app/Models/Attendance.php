<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    const LATE = 1;
    const NOT_LATE = 0;
    const FORGET = 3;

    protected $table = 'attendances';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'image_face',
        'user_code',
        'check_in',
        'check_out',
        'is_late'
    ];

    protected $appends = ['is_late_label'];

    public function getIsLateLabelAttribute()
    {
        $label = [
            '' => '',
            self::NOT_LATE => "",
            self::FORGET => "Forget",
            self::LATE => "Late",
        ];
        return $label[$this->is_late];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
