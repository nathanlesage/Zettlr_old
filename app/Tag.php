<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name'
    ];
    
    public function notes()
    {
    	return $this->belongsToMany('App\Note')->withTimeStamps();
    }
}
