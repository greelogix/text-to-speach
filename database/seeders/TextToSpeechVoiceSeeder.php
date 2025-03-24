<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Afaya\EdgeTTS\Service\EdgeTTS;
use App\Models\TextToSpeechVoice;

class TextToSpeechVoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tts = new EdgeTTS();
        $voices = $tts->getVoices();

        foreach ($voices as $voice) {
            TextToSpeechVoice::updateOrCreate(
                [
                    'short_name' => $voice['ShortName'],
                ],
                [
                    'name' => $voice['Name'],
                    'gender' => $voice['Gender'],
                    'locale' => $voice['Locale'],
                    'friendly_name' => $voice['FriendlyName'],
                ]
            );
        } 

    }
}
