<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name'];

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
}
