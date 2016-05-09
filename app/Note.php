<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Note;

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

    /**
     *  Relationship
     *
     *  @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    /**
     *  Relationship
     *
     *  @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notes()
    {
        // Inception part 2: Referencing a model within itself
        // blongsToMany(Note, pivot table name, first foreign, second foreign)
        return $this->belongsToMany('App\Note', 'note_note', 'note1_id', 'note2_id')->withTimeStamps();
    }

    /**
     *  Relationship
     *
     *  @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function outlines()
    {
        return $this->belongsToMany('App\Outline')->withPivot('index')->withTimestamps();
    }

    /**
     *  Relationship
     *
     *  @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function references()
    {
        return $this->belongsToMany('App\Reference')->withTimestamps();
    }

    /**
     *  Returns all previous related notes (previous means smaller id)
     *
     *  @return  App\Note  The previous notes
     */
    public function prev()
    {
        // Eager load all attached notes with a smaller ID than this
        $prevNotes = Note::whereHas('notes', function ($query) {
            $query->where('note2_id', '=', $this->id);
            $query->where('note1_id', '<', $this->id);
        })->get(['id']);

        return $prevNotes;
    }

    /**
     *  Returns all next related notes (next means bigger id)
     *
     *  @return  App\Note  The next notes
     */
    public function next()
    {
        // Eager load all attached notes with a bigger ID than this
        $nextNotes = Note::whereHas('notes', function ($query) {
            $query->where('note2_id', '=', $this->id);
            $query->where('note1_id', '>', $this->id);
        })->get(['id']);

        return $nextNotes;
    }
}
