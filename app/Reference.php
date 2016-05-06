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

    protected $types = [
      1 => "Audio Recording",
      2 => "Blogpost",
      3 => "Book",
      4 => "Book Section",
      5 => "Case",
      6 => "Conference Paper",
      7 => "Dictionary Entry",
      8 => "Document",
      9 => "Email",
      10 => "Encyclopedia Article",
      11 => "Film",
      12 => "Forum post",
      13 => "Interview",
      14 => "Journal Article",
      15 => "Letter",
      16 => "Magazine Article",
      17 => "Manuscript",
      18 => "Newspaper article",
      19 => "Note",
      20 => "Patent",
      21 => "Podcast",
      22 => "Presentation",
      23 => "Radio Broadcast",
      24 => "Report",
      25 => "Statute",
      26 => "Thesis",
      27 => "TV Broadcast",
      28 => "Video Recording",
      29 => "Webpage"
    ];

    public function notes()
    {
      return $this->belongsToMany('App\Note')->withTimestamps();
    }

    public function outlines()
    {
      return $this->belongsToMany('App\Outline')->withTimestamps();
    }

    public function getTypes()
    {
      return $this->types;
    }

    public function typeAllowed($type)
    {
        return in_array(strtolower($type), array_map('strtolower', $this->types));
    }

    public function getTypeLabel($typeId)
    {
      return $this->types[$typeId];
    }

    public function getTypeKey($label)
    {
        return array_search($label, $this->types);
    }
}
