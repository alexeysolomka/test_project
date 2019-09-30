<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metro extends Model
{
    public static $createRules = ['location' => 'required|string|max:30|unique:metros'];
    public static $updateRules = ['location' => 'required|string|max:30|unique:metros,location,'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['location', 'type_id'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
