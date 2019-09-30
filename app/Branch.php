<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'metro_id'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    public static function createValidationRules()
    {
        return [
            'name' => 'required|unique:branches'
        ];
    }

    public static function updateValidationRules($branch_id)
    {
        return [
            'name' => 'required|unique:branches,id,' . $branch_id
        ];
    }

    public function metro()
    {
        return $this->belongsTo(Metro::class);
    }
}
