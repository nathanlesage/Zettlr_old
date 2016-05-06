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

    /**
     *  An array of Zotero compatible doc types
     *
     *  @var  array
     */
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

    /**
     *  Return the $types array
     *
     *  @return  array
     */
    public function getTypes()
    {
      return $this->types;
    }

    /**
     *  Returns true, if the given $type is in the array
     *
     *  @param   string  $type  The type to be checked
     *
     *  @return  bool         True, if the value is in the array
     */
    public function typeAllowed($type)
    {
        return in_array(strtolower($type), array_map('strtolower', $this->types));
    }

    /**
     *  Get the value of a given key in the $types array
     *
     *  @param   integer  $typeId  The key
     *
     *  @return  string           The value
     */
    public function getTypeLabel($typeId)
    {
      return $this->types[$typeId];
    }

    /**
     *  Returns the key for a given value
     *
     *  @param   string  $label  The type as a string
     *
     *  @return  integer          The key
     */
    public function getTypeKey($label)
    {
        return array_search($label, $this->types);
    }
}
