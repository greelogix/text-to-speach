<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TTSController;
use App\Http\Controllers\ProjectController;  

Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/', function () {
    return view('index');
})->name('index.page');

Route::get('api/docs', function () {
    return view('api_docs');
})->name('api.docs');

Route::get('free/ttsvoiceover', function () {
    return view('index');
})->name('free.ttsvoiceover');


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/free_tts', [TTSController::class, 'free_tts'])->name('free.tts');

Route::middleware(['check.tts.limit'])->group(function () {
    Route::post('/generate-speech', [TTSController::class, 'generateSpeech'])->name('generate-text-to-speech');
});
Route::get('/languages', [TTSController::class, 'getLanguages']);
Route::get('/voices/{locale}', [TTSController::class, 'getVoicesByLanguage']);

Route::middleware(['auth'])->group(function () {
    Route::get('/generate-speech-page', [TTSController::class, 'generateSpeechPage'])->name('generate_speech_page');
    // Route::post('/generate-speech', [TTSController::class, 'generateSpeech'])->name('generate-text-to-speech');
    Route::post('/profile/{id}', [AuthController::class, 'update'])->name('profile.update');
    Route::get('/voices/list', [ProjectController::class, 'voices_list'])->name('voices.list');
    Route::get('/projects/list', [ProjectController::class, 'projects_list'])->name('projects.list');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('/delete_project/{id}', [ProjectController::class, 'delete_project'])->name('delete_project');
    Route::delete('/delete_voice/{id}', [ProjectController::class, 'delete_voice'])->name('delete_voice');
    Route::get('/project/{project_id}', [ProjectController::class, 'index'])->name('voices.index');
    Route::get('/apikey-page',[AuthController::class, 'index_key'])->name('apikey-page');
    
    Route::post('/api/key/generate', [AuthController::class, 'generateApiKey'])->name('api.key.generate');
   
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    

});
