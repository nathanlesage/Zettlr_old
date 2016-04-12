<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outline extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
  'name', 'description'
  ];

    public function notes()
    {
      return $this->belongsToMany('App\Note')->withPivot('index')->withTimestamps();
    }

    public function customFields()
    {
      return $this->hasMany('App\CustomField');
    }

    public function tags()
    {
      return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function references()
    {
      return $this->belongsToMany('App\Reference')->withTimestamps();
    }
}
