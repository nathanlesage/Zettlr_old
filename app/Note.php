<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'title', 'content'
    ];
    
    public function tags()
    {
    	return $this->belongsToMany('App\Tag')->withTimeStamps();
    }
}
