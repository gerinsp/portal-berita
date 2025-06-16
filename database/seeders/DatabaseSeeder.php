<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Redaction;
use App\Models\Guideline;
use App\Models\Disclaimer;
use App\Models\Contact;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'Agun Wiguna',
            'email' => 'admin@texno.id',
            'password' => bcrypt('admin123'),
            'roles' => 'Administrator'
        ]);

        User::create([
            'name' => 'Jhon Doe',
            'email' => 'editor@texno.id',
            'password' => bcrypt('editor123'),
            'roles' => 'Editor'
        ]);

        User::create([
            'name' => 'Valeria Luna',
            'email' => 'penulis@texno.id',
            'password' => bcrypt('penulis123'),
            'roles' => 'Penulis'
        ]);

        Category::create([
            'name' => 'Berita',
            'slug' => 'berita'
        ]);

        Category::create([
            'name' => 'Internet',
            'slug' => 'internet'
        ]);

        Category::create([
            'name' => 'Gadget',
            'slug' => 'gadget'
        ]);

        Category::create([
            'name' => 'Sains',
            'slug' => 'sains'
        ]);

        Category::create([
            'name' => 'Game',
            'slug' => 'game'
        ]);

        Category::create([
            'name' => 'Tutorial',
            'slug' => 'tutorial'
        ]);

        Tag::create([
            'name' => 'Berita Terbaru',
            'slug' => 'berita-terbaru'
        ]);

        Tag::create([
            'name' => 'Berita Teknologi',
            'slug' => 'berita-teknologi'
        ]);

        Redaction::create([
            'redaction_content' => '
            <p>
                Dikelola oleh : <b> PT Harapan Rakyat Media </b> <br/><br/>

                <b>Pimpinan Umum </b>: Subagja Hamara <br/><br/>

                <b> Pimpinan Redaksi </b> : Subagja Hamara <br/>
                <b> Sekretaris Redaksi </b> : Deni Supendi <br/>
                <b> Redaktur Pelaksana </b> : – <br/>
                <b> Redaktur </b> : Deni Supendi, <br/>
                <b> Staf Redaksi </b> : <br/><br/>

                <b> Penulis Konten </b> : <br/><br/>

                <b> Ass. Pimpinan Perusahaan </b> : Deni Supendi <br/>
                <b> Keuangan </b> : Muhafid <br/>
                <b> Iklan </b> : <br/><br/>

                <b> WebMaster </b> : NamaKamu.com
            <p>'
        ]);

        Guideline::create([
            'guideline_content' => '
            <p>
                PERATURAN DEWAN PERS 
            <p>'
        ]);

        Disclaimer::create([
            'disclaimer_content' => '
            <p>
                Disclaimer 
            <p>'
        ]);

        Contact::create([
            'contact_content' => '
            <p>
                Kontak 
            <p>'
        ]);
    }
}
