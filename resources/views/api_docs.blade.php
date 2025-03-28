<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text-to-Speech API Documentation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="pt-4 text-end pe-5">
        <a href="{{route('register.form')}}" class="me-4">Create account</a>
        <a href="{{route('login')}}" class="inline-block bg-blue-600 text-white py-1 px-5 rounded-lg text-md">login</a>
    </div>
    <div class="container mx-auto p-6">
        <!-- Hero Section -->
        <div class="text-center py-10">
            <h1 class="text-4xl font-bold text-gray-800">Text-to-Speech API</h1>
            <p class="text-lg text-gray-600 mt-2">Convert text into natural-sounding speech with ease.</p>
            {{-- <a href="/login" class="mt-4 inline-block bg-blue-600 text-white py-2 px-6 rounded-lg text-lg">Get Started</a> --}}
        </div>
        
        <!-- Features -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-center">Features</h2>
            <ul class="list-disc list-inside text-gray-700 mt-4">
                <li><strong>Text-to-Speech:</strong> Convert text into natural-sounding speech using Microsoft Edge's TTS.</li>
                <li class="mt-3"><strong>Multiple Voices:</strong> Choose from various voices to suit your project.</li>
                <li class="mt-3"><strong>Audio Export:</strong> Export audio as raw, base64, or a downloadable file.</li>
                <li class="mt-3"><strong>Pause Feature:</strong> Insert predefined pauses ([0.5s] to [4s]) into the text at the cursor position.</li>  
                <li class="mt-3"><strong>Pause Format:</strong> Pauses appear as [Xs], where X is the duration in seconds (e.g., [1s], [2.5s]).</li>  
                <li class="mt-3"><strong>Usage Example:</strong> "Hello, how are [1s] you?" or "I will be there in [2.5s] a moment."</li>  
            </ul>
        </div>
        
        <!-- How It Works -->
        <div class="mt-10 bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-semibold">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-lg">1. Login</h3>
                    <p class="text-gray-600">Sign up or log in to your account to access the dashboard.</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-lg">2. Generate API Key</h3>
                    <p class="text-gray-600">Click the 'Generate API Key' button to obtain your unique API key.</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-lg">3. Use API</h3>
                    <p class="text-gray-600">Send HTTP requests with your API key to receive TTS audio responses.</p>
                </div>
            </div>
        </div>
        
        <!-- API Key Generation -->
        {{-- <div class="mt-10 p-6 bg-white rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-semibold">Generate Your API Key</h2>
            <p class="text-gray-600 mt-2">Get an API key to start using text-to-speech services.</p>
            <a href="/dashboard" class="mt-4 inline-block bg-green-600 text-white py-2 px-6 rounded-lg text-lg">Generate API Key</a>
        </div> --}}
        
        <!-- API Endpoint -->
        <div class="mt-10 p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold">API Endpoint</h2>
            <pre class="bg-gray-900 text-white p-4 rounded-lg mt-2">
                curl -X POST "https://api.example.com/tts" \
                -H "X-API-KEY: 87498543hrrjwebfr77fbf3793" \
                -H "Content-Type: application/json" \
                -d '{ "text": "Hello, this is a text-to-speech conversion!",
                "voice": "en-US-JennyNeural",
                "rate": "0%",       // Speech rate (range: -100% to 100%)
                "volume": "0%",     // Speech volume (range: -100% to 100%)
                "pitch": "0Hz"}'    // Voice pitch (range: -100Hz to 100Hz)
                
            </pre>
        </div>
        
        <!-- Usage Limit -->
        <div class="mt-10 p-6 bg-white rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-semibold">Usage Limits</h2>
            <p class="text-gray-600 mt-2">Each API key includes 100 free text-to-speech conversions.</p>
            <p class="text-gray-600">For additional usage, upgrade your plan in the dashboard.</p>
        </div>
    </div>
</body>
</html>
