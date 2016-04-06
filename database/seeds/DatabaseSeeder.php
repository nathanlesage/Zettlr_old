<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        
        // Create an admin account to login
        // easily without having to harass with always
        // having to manually register
        DB::table('users')->insert([
        'name' => "admin",
        'email' => 'test@example.com',
        'password' => bcrypt('admin')]);
        
        DB::table('notes')->insert([
        	'title' => 'Eine erste Test-Notiz',
        	'content' => '# Eine Überschrift
        	
        	Mit einem Zeilenumbruch
        	
        	> und einem Blockquote'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Eine weitere Notiz',
        	'content' => '# Heading 1
        	
        	Mit einem `Zeilenumbruch`
        	
        	> und einem Blockquote'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Noch eine, weil es so schön ist',
        	'content' => '> Diesmal keine Überschrift
        	
        	Dafür ganz viel `Spaß`.'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Numero quatro',
        	'content' => '> Diesmal nur mit `Blockquote`'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Mambo number five',
        	'content' => '## Gedanken
        	
        	Das war wirklich eines der schlimmeren Lieder der 90er...'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Eine sechste Notiz',
        	'content' => 'Wieder ohne Überschrift
        	
        	Dafür mit ein paar
        	
        	Zeilenumbrüchen
        	
        	> und einem Blockquote'
        ]);
        
        DB::table('tags')->insert(['name' => "Luhmann"]);
        DB::table('tags')->insert(['name' => "Foucault"]);
        DB::table('tags')->insert(['name' => "Produktionsmittel"]);
        DB::table('tags')->insert(['name' => "Weltrevolution"]);
        DB::table('tags')->insert(['name' => "dafuq"]);
        DB::table('tags')->insert(['name' => "wtf"]);
        DB::table('tags')->insert(['name' => "Kapitalismus"]);
        DB::table('tags')->insert(['name' => "Heteronormativität"]);
        DB::table('tags')->insert(['name' => "Heteroskedastizität"]);
        DB::table('tags')->insert(['name' => "Mao"]);
        
        
    }
}
