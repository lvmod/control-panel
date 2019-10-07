<?php
namespace Lvmod\ControlPanel\Seeds;

use Illuminate\Database\Seeder;
use Lvmod\ControlPanel\Models\MultimediaType;

class MultimediaTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MultimediaType::firstOrCreate(['name' => 'folder'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Documents/Grey/Stroke/@2x/icon-95-folder@2x.png',
        ]);

        MultimediaType::firstOrCreate(['name' => 'jpg'], [
            'makepreview' => 1,
            'display' => 1,
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-74-document-file-jpg@2x.png',
            'viewer' => 'image',
        ]);

        MultimediaType::firstOrCreate(['name' => 'jpeg'], [
            'makepreview' => 1,
            'display' => 1,
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-74-document-file-jpg@2x.png',
            'viewer' => 'image',
        ]);

        MultimediaType::firstOrCreate(['name' => 'gif'], [
            'makepreview' => 1,
            'display' => 1,
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-130-document-file-gif@2x.png',
            'viewer' => 'image',
        ]);

        MultimediaType::firstOrCreate(['name' => 'png'], [
            'makepreview' => 1,
            'display' => 1,
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-69-document-file-png@2x.png',
            'viewer' => 'image',
        ]);

        MultimediaType::firstOrCreate(['name' => 'tiff'], [
            'makepreview' => 1,
            'display' => 1,
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-84-document-file-tiff@2x.png',
            'viewer' => 'image',
        ]);

        MultimediaType::firstOrCreate(['name' => 'doc'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-94-document-file-doc@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'docx'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-97-document-file-docx@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'xls'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-96-document-file-xls@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'xlsx'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-109-document-file-xlsx@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'ppt'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-98-document-file-ppt@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'pptx'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-98-document-file-ppt@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'pdf'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-70-document-file-pdf@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'rtf'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-114-document-file-rtf@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'zip'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-124-document-file-zip@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => '7z'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-124-document-file-zip@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => '7zip'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-124-document-file-zip@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'rar'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-129-document-file-rar@2x.png',
            'viewer' => 'google',
        ]);

        MultimediaType::firstOrCreate(['name' => 'mp3'], [
            'default_preview' => '/vendor/control-panel/dist/img/PNG/Filetypes/Grey/Stroke/@2x/icon-6-file-mp3@2x.png',
            'viewer' => 'google',
        ]);
    }
}
