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

    /**
     *  Relationship
     *
     *  @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notes()
    {
    	return $this->belongsToMany('App\Note')->withTimestamps();
    }

    /**
     *  Relationship
     *
     *  @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function outlines()
    {
      return $this->belongsToMany('App\Outline')->withTimestamps();
    }
}
