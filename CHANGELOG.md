# Changelog for Zettlr

## tba

* Now the settings pane takes over changes of username or email, if an error happened in form submission
* Zettlr now displays tags and references on note create/edit pages after an error occurred
* Adapted display of tags on outline create/edit-pages
* Fixed an issue, which caused references to be lost after editing, as the reference ID has not been passed to the form
* Layout of note IDs on list.blade.php changed
* [tech] Removed vendor from repo and adapted the composer.json file to reflect this is just an app based on laravel and not laravel itself
* Updated layout of related notes in notes/show, added functionality to unlink notes that are linked
* Updated layout of tag list
* Added show-template to list all notes of a specific tag.
* Updated tag display to everywhere have more margin
* Limited retrieved tags, references and notes in searches to 20 (notes: 15) to ease the flood out a little bit
* Made the tag-list sortable (to filter out unused tags, search for tags, etc.)
* Switched to a local less compiler for more consistency and options to configure
* Adapted design and moved main.css-contents into bootstrap less-files
* Tags now link to their respective overview page
* Implemented trails: Zettlr can now search through all linked notes and display all individual paths

## v0.1.1-beta (2016-04-17)

* Fixed accidental submission of forms by hitting `Enter` in a Text field
* Fixed a bug that caused outlines to randomly select notes to show, if there are no custom fields available
* Fixed a bug that caused attached tags from outlines not to be attached to the respective notes and created a `$tag->name` pseudo-tag
* Same issue fixed with references
* Fixed an issue that redirected to the "normal" note creation instead of passing on the outline ID when an error was detected, causing tags and references to be lost
* Fixed `Enter` key submission on login form
* Changed layout for the tagList to make room for more tags and prevent exceeding the bottom of the container for a little bit longer
* Fixed an error where UTF-8 strings (with chars like ä, ö, ø, etc) in notes caused an internal laravel error when using the search field, if these characters were split in half by php's `subtr()`-function

## v0.1.0-beta

* Initial release
