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
    
    public function notes()
    {
    	// Inception part 2: Referencing a model within itself
    	// blongsToMany(Note, pivot table name, first foreign, second foreign)
    	return $this->belongsToMany('App\Note', 'note_note', 'note1_id', 'note2_id')->withTimeStamps();
    }
}
