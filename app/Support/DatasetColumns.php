<?php

namespace App\Support;

/**
 * Maps database column names to human-readable labels for the dataset
 */
class DatasetColumns
{
    /**
     * Get all available columns with human-readable labels
     */
    public static function all(): array
    {
        return [
            'gender' => 'Gender',
            'occupation_type' => 'Occupation Type',
            'avg_work_hours_per_day' => 'Daily Work Hours',
            'avg_rest_hours_per_day' => 'Daily Rest Hours',
            'avg_sleep_hours_per_day' => 'Daily Sleep Hours',
            'avg_exercise_hours_per_day' => 'Daily Exercise Hours',
            'age_at_death' => 'Age at Death',
        ];
    }

    /**
     * Get the human-readable label for a column
     */
    public static function label(string $column): string
    {
        return self::all()[$column] ?? $column;
    }

    /**
     * Get all column descriptions for reference
     */
    public static function descriptions(): array
    {
        return [
            'gender' => 'Occupant gender classification',
            'occupation_type' => 'Classification of employment type',
            'avg_work_hours_per_day' => 'Average hours worked per day',
            'avg_rest_hours_per_day' => 'Average rest hours per day',
            'avg_sleep_hours_per_day' => 'Average sleep hours per day',
            'avg_exercise_hours_per_day' => 'Average exercise hours per day',
            'age_at_death' => 'Subject age when deceased',
        ];
    }
}
