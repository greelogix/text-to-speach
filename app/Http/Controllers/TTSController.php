<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\Voice;
use Illuminate\Support\Facades\Auth;
use Afaya\EdgeTTS\Service\EdgeTTS;
use App\Models\TextToSpeechVoice;

class TTSController extends Controller
{
    public function generateSpeechPage()
    {
        return view('text_to_speech');
    }
    public function free_tts()
    {
        return view('free_tts');
    }

    public function generateSpeech(Request $request)
    {
        try {

            $request->validate([
                'text' => 'required|string',
                'rate' => 'nullable|string|min:-100|max:100',
                'volume' => 'nullable|string|min:-100|max:100',
                'pitch' => 'nullable|string',
                'project_name' => 'required|string|max:255',
                'projectid' => 'nullable|integer|exists:projects,id',
                'voice' => 'nullable|string',
                'saveAudio' => 'nullable|boolean',
            ]);
    
            $text = trim($request->input('text'));
            $projectid = $request->input('projectid');
            $project_name = trim($request->input('project_name'));
            $voice = $request->input('voice');
            $saveAudio = $request->boolean('saveAudio');
    
            if (empty($text) || empty($project_name)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Text & Project Name cannot be empty',
                ], 400);
            }
    
            $tts = new EdgeTTS();

            if (!method_exists($tts, 'synthesize')) {
                throw new \Exception("EdgeTTS method 'synthesize' does not exist.");
            }
    
            $tts->synthesize($text, $voice, [
                'rate' => $request->rate,
                'volume' => $request->volume,
                'pitch' => $request->pitch,
            ]);

            $audioData = $tts->toBase64();


            // $audioBinary = base64_decode($audioData);
            // $audioFileName = 'tts_audio_' . time() . '.mp3';
            // Storage::disk('public')->put($audioFileName, $audioBinary);

            if (empty($audioData)) {
                throw new \Exception("Failed to generate speech audio.");
            }
    
            $updateMessage = 'no_update';
    
            // Save voice data
            if ($projectid) {
                Voice::create([
                    'project_id' => $projectid,
                    'title' => $project_name,
                    'text_to_audio' => $audioData,
                ]);
                $updateMessage = 'update_voice';
            }
    
            if ($saveAudio) {
                $project = Project::create([
                    'user_id' => Auth::id(),
                    'project_name' => $project_name,
                ]);
    
                Voice::create([
                    'project_id' => $project->id,
                    'title' => $project_name,
                    'text_to_audio' => $audioData,
                ]);
            }
    
            return response()->json([
                'status' => 'success',
                'message' => 'TTS processed successfully!',
                'update_voice' => $updateMessage,
                'audio_base64' => $audioData, 
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error in generateSpeech method: " . $e->getMessage() . " - Line: " . $e->getLine());
    
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(), 
            ], 500);
        }
    }
    
      public function getLanguages()
        {
            return response()->json(
                TextToSpeechVoice::distinct()
                    ->pluck('locale')
                    ->mapWithKeys(fn($locale) => [$locale => locale_get_display_name($locale, 'en')])
            );
        }

        public function getVoicesByLanguage(string $locale)
        {
            return response()->json(
                TextToSpeechVoice::where('locale', $locale)->get()
            );
        } 
}
