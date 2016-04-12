<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'content', 'type', 'index', 'outline_id'
    ];

    public function outline()
    {
      return $this->belongsTo('App\Outline')->withTimestamps();
    }
}
