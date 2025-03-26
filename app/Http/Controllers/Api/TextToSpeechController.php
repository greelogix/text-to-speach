<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Afaya\EdgeTTS\Service\EdgeTTS;

class TextToSpeechController extends Controller
{
    public function synthesize(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:1000',
            'voice' => 'required|string',
            'rate' => 'nullable|string',
            'volume' => 'nullable|string',
            'pitch' => 'nullable|string',
        ]);

        $apiKey = $request->header('X-API-KEY');
        $keyRecord = ApiKey::where('key', $apiKey)->first();

        if (!$keyRecord || $keyRecord->quota <= 0) {
            return response()->json(['error' => 'Invalid or expired API Key'], 403);
        }

        $tts = new EdgeTTS();

        if (!method_exists($tts, 'synthesize')) {
            return response()->json(['error' => "EdgeTTS method 'synthesize' does not exist."], 500);
        }

        try {
             $tts->synthesize($request->text, $request->voice, [
                'rate' => $request->rate ?? '0%',
                'volume' => $request->volume ?? '0%',
                'pitch' => $request->pitch ?? '0Hz',
            ]);

            $keyRecord->decrement('quota');
            $audioData = $tts->toBase64();

            return response()->json([
                'message' => 'TTS successfully generated.',
                'audio' => $audioData,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
