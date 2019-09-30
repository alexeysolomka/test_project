<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public static $createRules = [
        'name' => 'required|unique:branches',
        'metro_id' => 'required|exists:metros,id'
    ];
    public static $updateRules = [
        'name' => 'required|unique:branches,name,',
        'metro_id' => 'required|exists:metros,id'
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
