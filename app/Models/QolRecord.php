<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QolRecord extends Model
{
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qol_records';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'gender',
        'occupation_type',
        'avg_work_hours_per_day',
        'avg_rest_hours_per_day',
        'avg_sleep_hours_per_day',
        'avg_exercise_hours_per_day',
        'age_at_death',
    ];
}
