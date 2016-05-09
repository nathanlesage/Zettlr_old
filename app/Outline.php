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

    /**
     *  Relationship
     *
     *  @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notes()
    {
        return $this->belongsToMany('App\Note')->withPivot('index')->withTimestamps();
    }

    /**
     *  Relationship
     *
     *  @return  Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customFields()
    {
        return $this->hasMany('App\CustomField');
    }

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
    public function references()
    {
        return $this->belongsToMany('App\Reference')->withTimestamps();
    }
}
