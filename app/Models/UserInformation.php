<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class UserInformation extends Model
{
    use HasFactory, Compoships;

    const IS_TRAINING = 1;
    const IS_NOT_TRAINING = 0;


    protected $table = 'user_informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_code',
        'name',
        'birthday',
        'department_id',
        'position_id',
        'total_amount'
    ];

    public function getTrainingLabelAttribute()
    {
        $labels = [
            '' => '',
            self::IS_NOT_TRAINING => 'No',
            self::IS_TRAINING => 'Yes',
        ];
        return $labels[$this->is_training];
    }

    /**
     * Get the department that owns the user information
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    /**
     * Get the position that owns the user information
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id');
    }

    /**
     * Get the salary that owns the user information
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function salary()
    {
        return $this->hasOne(Salary::class, ['department_id', 'position_id'], ['department_id', 'position_id']);
    }
}
