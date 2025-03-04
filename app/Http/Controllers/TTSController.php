<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as SupportFFMpeg;

class TTSController extends Controller
{
    // public function generateSpeech(Request $request)
    // {
        
    //     $request->validate([
    //         'text' => 'required|string|max:5000',
    //         'lang' => 'nullable|string',
    //     ]);

    //     $text = trim($request->input('text'));

    //     $lang = $request->input('lang', 'en'); 

    //       $encodedText = urlencode($text);

    //       $url = "https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q={$encodedText}&tl={$lang}";
  

    //     $response = Http::get($url);

    //     if ($response->successful()) {
    //         $directory = 'audio/';
    //         $existingFiles = Storage::disk('public')->files($directory);
    
    //         if (!empty($existingFiles)) {
    //             Storage::disk('public')->delete($existingFiles);
    //         }
    
    //         $fileName = 'tts_' . time() . '.mp3';
    //         $path = $directory . $fileName; 
    
    //         Storage::disk('public')->put($path, $response->body());
    
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'TTS generated successfully!',
    //             'audio_url' => asset('storage/' . $path),
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Failed to generate speech'
    //     ], 500);
    // }


    // public function generateSpeech(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'text' => 'required|string',
    //             'lang' => 'nullable|string',
    //         ]);
    
    //         $text = trim($request->input('text'));
    //         $lang = $request->input('lang', 'en');
    
    //         if (empty($text)) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Text cannot be empty',
    //             ], 400);
    //         }

    //         $chunks = str_split($text, 200);
    //         $audioUrls = [];
    
    //         foreach ($chunks as $index => $chunk) {
    //             $encodedText = urlencode($chunk);
            
    //             $url = "https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q={$encodedText}&tl={$lang}";
            
    //             $response = Http::get($url);
            
    //             if ($response->successful() && $response->header('Content-Type') === 'audio/mpeg') {
    //                 $fileName = 'tts_' . time() . '_' . uniqid() . '.mp3';
    //                 $path = 'audio/' . $fileName;
            
    //                 Storage::disk('public')->put($path, $response->body());
    //                 $audioUrls[] = asset('storage/' . $path);
    //             } else {
    //                 Log::error("Failed to generate speech for chunk $index: " . $response->body());
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'message' => 'Failed to generate speech.',
    //                 ], 500);
    //             }
    //         }
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'TTS generated successfully!',
    //             'audio_urls' => $audioUrls,
    //         ]);
            
    
    //     } catch (\Exception $e) {
    //         Log::error("Error in generateSpeech method: " . $e->getMessage());
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'An error occurred while generating speech',
    //         ], 500);
    //     }
    // }

    public function generateSpeech(Request $request)
    {
        try {
            $request->validate([
                'text' => 'required|string',
                'lang' => 'nullable|string',
            ]);

            $text = trim($request->input('text'));
            $lang = $request->input('lang', 'en');

            if (empty($text)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Text cannot be empty',
                ], 400);
            }

            $chunks = str_split($text, 200);
            $audioFiles = [];
                $directory = 'audio/';
                $existingFiles = Storage::disk('public')->files($directory);
                
                if (!empty($existingFiles)) {
                    Storage::disk('public')->delete($existingFiles);
                }

            foreach ($chunks as $index => $chunk) {
                $encodedText = urlencode($chunk);
                $url = "https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q={$encodedText}&tl={$lang}";

                $response = Http::get($url);

                if ($response->successful() && $response->header('Content-Type') === 'audio/mpeg') {
                    $fileName = 'tts_' . time() . '_' . uniqid() . '.mp3';
                    $path = 'audio/' . $fileName;

                    Storage::disk('public')->put($path, $response->body());
                    $audioFiles[] = storage_path('app/public/' . $path);
                } else {
                    Log::error("Failed to generate speech for chunk $index: " . $response->body());
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to generate speech.',
                    ], 500);
                }
            }

            $mergedAudioPath = storage_path('app/public/audio/merged_' . time() . '.mp3');
            $finalAudio = '';

            foreach ($audioFiles as $file) {
                $finalAudio .= file_get_contents($file);
            }

            file_put_contents($mergedAudioPath, $finalAudio);

            return response()->json([
                'status' => 'success',
                'message' => 'TTS generated and merged successfully!',
                'audio_url' => asset('storage/audio/' . basename($mergedAudioPath)),
            ]);

        } catch (\Exception $e) {
            Log::error("Error in generateSpeech method: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while generating speech',
            ], 500);
        }
    }
}
