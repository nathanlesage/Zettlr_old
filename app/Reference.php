<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'title', 'year', 'author_last', 'author_first', 'reference_type'
    ];

    public function notes()
    {
      return $this->belongsToMany('App\Note')->withTimestamps();
    }

    public function outlines()
    {
      return $this->belongsToMany('App\Outline')->withTimestamps();
    }
}
