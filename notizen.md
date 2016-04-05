# Datenbank-Tabellen

* WICHTIG: Folgendes machen, um die Datenbank zu bauen:

1. artisan migrate

# Hilfe

Guter Artikel zum Thema Eloquent ORM (der auch die one-to-many-Relation erklärt):

https://scotch.io/tutorials/a-guide-to-using-eloquent-orm-in-laravel

* WICHTIG: Folgendes machen, wenn die DB-Struktur sich VERÄNDERT hat:

1. artisan down (Dann kann keiner mehr auf die App zugreifen, eigentlich nur für ausgerollte Installationen wichtig, aber kann man sich ja angewöhnen)
2. composer dump-autoload (baut irgendwelche Files die der Migrator dann nutzt)
3. artisan migrate:rollback (nichts anderes als "schmeiß die Tabellen alle raus")
4. artisan migrate (die Tabellen wieder anlegen in der "richtigen" Struktur)
5. artisan db:seed (Fügt die Testdaten in die Datenbank ein)
6. artisan up (Wieder in den Production-Modus)

## Notes

Enthält die einzelnen Zettel sowie Informationen, die unique dafür sind.

Eigene Spalten (nicht via die migration von artisan):

> $table->string('The notes title')
> $table->longText('The notes contents')
> Liste von IDs für die Schlagworte
> Liste von IDs der verweisenden Zettel (von wo?)
> Liste von IDs der verwiesenen Zettel (wohin?)
> Liste von IDs der einzelnen bibliographischen Angaben
> Titel

## Tags

Enthält die Schlagworte

> tag_id
> tag_string

## bibliography

Enthält die Werke

> bib_id
> bib_string
> bib_isbn? (irgendeinen Zahlen-Identifier brauch ich auf jeden Fall)

## join-tables

1. Zwischen Notizen und Werken plus Schlagworten
2. Zwischen Notizen und Notizen 

Zwischen den anderen Tables brauch ich nix

## Mal kurz die many-to-many-relations basteln

Konzept eines Join-Tables: Es registriert alle Verbindungen

Das heißt man hat zwei Tabellen, und in der Mitte die join-table

Das heißt: Erstmal gucken: Was hängt mit was zusammen?

Notes --> tags, bibliograpy
> note_tags_bib_join
>> note_id, tag_id

tags -> Notes

bibliograpy -> Notes

Notes --> Notes (also selbstreferenz)

> Selbstreferenz-Join-Table

Note_ID Note_ID

Oh gosh. We will die.
