<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;

    protected $table = 'user_informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'birthday',
        'department_id',
        'position_id',
        'total_amount'
    ];

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
        return $this->hasOne(Salary::class, 'department_id', 'department_id')->wherePositionId($this->position_id);
    }
}
