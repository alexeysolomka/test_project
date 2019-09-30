<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public static $createRules = [
        'name' => 'required|max:30|unique:branches',
        'metro_id' => 'required|exists:metros,id'
    ];
    public static $updateRules = [
        'metro_id' => 'required|exists:metros,id',
        'name' => 'required|max:30|unique:branches,name,'
    ];

    protected $fillable = ['name', 'metro_id'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    public function metro()
    {
        return $this->belongsTo(Metro::class);
    }
}
