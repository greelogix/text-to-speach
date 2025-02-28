<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TTSController extends Controller
{
    public function generateSpeech(Request $request)
    {
        // dd('text');
        $request->validate([
            'text' => 'required|string|max:200',
            'lang' => 'nullable|string',
        ]);

        $text = trim($request->input('text'));

        $lang = $request->input('lang', 'en'); 

          $encodedText = urlencode($text);

          $url = "https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q={$encodedText}&tl={$lang}";
  

        $response = Http::get($url);

        if ($response->successful()) {
            $fileName = 'tts_' . time() . '.mp3';
            $path = 'audio/' . $fileName; 

            Storage::disk('public')->put($path, $response->body());
    
            return response()->json([
                'status' => 'success',
                'message' => 'TTS generated successfully!',
                'audio_url' => asset('storage/' . $path),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to generate speech'
        ], 500);
    }
}
