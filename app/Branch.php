<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public static $createRules = ['name' => 'required|unique:branches'];
    public static $updateRules = ['name' => 'required|unique:branches,id,'];

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
