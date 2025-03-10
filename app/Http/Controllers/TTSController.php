<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\Voice;
use Illuminate\Support\Facades\Auth;

class TTSController extends Controller
{
    public function generateSpeechPage()
    {
        return view('text_to_speech');
    }
    public function generateSpeech(Request $request)
    {
        try {
            $request->validate([
                'text' => 'required|string',
                'lang' => 'nullable|string',
                'project_name' => 'required|string|max:255',
                'projectid' => 'nullable|integer',
            ]);

            $text = trim($request->input('text'));
            $projectid = $request->input('projectid');
            $project_name = trim($request->input('project_name'));
            $lang = $request->input('lang', 'en');
            $saveAudio = $request->input('saveAudio', false);

            if (empty($text) || empty($project_name)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Text & Title cannot be empty',
                ], 400);
            }

            $chunks = str_split($text, 200);
            $audioData = '';

            foreach ($chunks as $chunk) {
                $encodedText = urlencode($chunk);
                $url = "https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q={$encodedText}&tl={$lang}";

                $response = Http::get($url);

                if ($response->successful() && $response->header('Content-Type') === 'audio/mpeg') {
                    $audioData .= $response->body();
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to generate speech.',
                    ], 500);
                }
            }

            $base64Audio = base64_encode($audioData);
            $updateMessage = 'no_update';

                if ($projectid) {
                    Voice::create([
                        'project_id' => $projectid,
                        'title' => $project_name,
                        'text_to_audio' => $base64Audio,
                    ]);
                    $updateMessage = 'update_voice';
                } 

             if ($saveAudio) {
                $project = Project::create([
                    'user_id' => Auth::id(),
                    'project_name' => $project_name,
                ]);

                if ($project) {
                    Voice::create([
                        'project_id' => $project->id,
                        'title' => $project_name,
                        'text_to_audio' => $base64Audio,
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'TTS processed successfully!',
                'update_voice' => $updateMessage,
                'audio_base64' => $base64Audio,
            ]);
        } catch (\Exception $e) {
            Log::error("Error in generateSpeech method: " . $e->getMessage() . " - Line: " . $e->getLine());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
