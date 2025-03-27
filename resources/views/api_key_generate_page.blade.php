@extends('layouts.main')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h2 class="mb-3">API Key Generator</h2>
            <form method="POST" action="{{ route('api.key.generate') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" name="purpose" id="purpose" class="form-control shadow-none" placeholder="Enter purpose for API key" required>
                    @error('purpose')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 shadow-none">Generate Key</button>
            </form>
        </div>
    </div>

    @if(isset($apiKey))
        <div class="mt-5">
            <label class="form-label">API Key:</label>
            <div class="input-group">
                <input type="text" id="apiKey" class="form-control shadow-none" value="{{ $apiKey->key }}" readonly>
                <button onclick="copyApiKey()" class="btn btn-outline-primary shadow-none">Copy</button>
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Remaining Quota:</label>
            <p class="fw-bold">{{ $apiKey->quota }} / 100</p>
        </div>

        <div class="mt-3">
            <label class="form-label">API Endpoint:</label>
            <div class="border p-2 bg-light">
                <code>{{ url('/api/text-to-speech') }}</code>
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Example Usage (cURL):</label>
            <div class="border p-2 bg-light">
                <code>
                    curl -X POST "{{ url('/api/text-to-speech') }}" \
                    -H "X-API-KEY: {{ $apiKey->key }}" \
                    -H "Content-Type: application/json" \
                    -d '{ "text": "Hello, this is a text-to-speech conversion!",
                    "voice": "en-US-JennyNeural",
                    "rate": "0%",
                    "volume": "0%",
                    "pitch": "0Hz"}'
                </code>
            </div>
        </div>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    function copyApiKey() {
        let apiKeyInput = document.getElementById("apiKey");
        navigator.clipboard.writeText(apiKeyInput.value).then(() => {
            console.log('API Key copied!');
        }).catch(err => {
            console.error("Failed to copy:", err);
        });
    }
</script>

@endsection
