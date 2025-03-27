<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Convert text to professional voiceovers in 50+ languages with TTSVoiceOver.com. Text-to-speech, voiceovers, and audio/video transcription all in one place.">
    <meta name="keywords" content="Text to Speech, AI Voiceover, Audio Transcription, Video to Text, Multilingual Voiceovers, TTS Online">
    <title>TTSVoiceOver.com - Text to Speech & AI Voiceovers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.flaticon.com/path-to-icons.css">
    {{-- <link rel="stylesheet" href="css/style.css"> --}}
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .hero {
            background: #f8f9fa;
            padding: 100px 20px;
            text-align: center;
        }
        .hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .feature-icon {
            font-size: 3rem;
            color: #007bff;
        }
        .cta-section {
            background: #007bff;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
        }
        .voice-card {
  border: 2px solid transparent;
  background: linear-gradient(135deg, #ffffff, #f8f9fa);
  padding: 15px;
  border-radius: 12px;
  transition: 0.3s;
  display: flex;
  align-items: center;
  cursor: pointer;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.voice-card:hover, .voice-card.active {
  border-color: #6f42c1;
  box-shadow: 0 6px 12px rgba(111, 66, 193, 0.3);
  background: linear-gradient(135deg, #6f42c1, #9b59b6);
  color: white;
}

.voice-card:hover .free {
  background: #ff9800;
  color: white;
}

.voice-img img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #f0f0f0;
  border: 2px solid #6f42c1;
  padding: 5px;
}

.voice-info h6 {
  margin: 0;
  font-size: 16px;
  font-weight: bold;
}

.voice-info .free {
  font-size: 12px;
  font-weight: bold;
  color: white;
  background: orange;
  padding: 3px 8px;
  border-radius: 8px;
}


.font-family{
  font-family: monospace;
}

#languageDropdown {
  height: 38px !important;
  padding: 6px 12px;
  border-radius: 5px;
}
.select2-container .select2-selection--single {
  height: 38px !important;
  display: flex;
  align-items: center;
  border: 1px solid #c6c6c6;
}
.border-style{
  border: 1px solid #c6c6c6;
}
.select2-selection__clear{
  display: none !important;
}
.custom-modal {
  width: 270px;
  height: 125px;
  background: #fff;
  border-radius: 12px;
  padding: 15px;
  text-align: center;
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
}
.btn-circle {
  width: 40px;
  height: 40px;
  border-radius: 20%;
  border: none;
  color: white;
  background: #9783f1;
  font-size: 20px;
  font-weight: bold;
}

@media (max-width: 768px) { 
    .hero {
        padding: 100px 0px;
    }
    .row-feature {
        flex-direction: column;
        align-items: center;
    }
    .d-flex-feature {
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .btn-group-convert {
        width: 100%;
        text-align: center;
    }

    .btn-group-convert .dropdown-toggle {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    .btn-free{
        margin-top: 10px;
    }

    .btn {
        width: 100%;
    }
    .card-style{
        padding: 10px 10px !important;
     }
}


    </style>
</head>
<body>
<!-- navbar -->
<nav class="navbar navbar-light bg-white shadow-sm fixed-top w-100">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold fs-4 text-dark">MyWebsite</a>
        <div>
            <a href="{{route('api.docs')}}" class="text-decoration-none me-2 px-2 text-dark">API Keys</a>
            <a href="#" class="text-decoration-none me-2 px-2 text-dark">Pricing</a>
            <a href="#" class="text-decoration-none px-2 text-dark">Contact</a>
        </div>
    </div>
</nav>
<!-- Hero Section -->
<section class="hero mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <h1>Convert Text to Professional Voiceovers in 50+ Languages</h1>
                <p class="lead">Instant text-to-speech, AI voiceovers & audio/video to text transcription – fast, affordable & multilingual.</p>
                <a href="#features" class="btn btn-primary btn-lg">Explore Features</a>
                <button class="btn btn-primary btn-lg btn-free">Start Free Trial</button>
            </div>
            <div class="col-12 col-md-6">
                     {{-- locall --}}
                    <audio controls class="w-100 mb-2">
                        <source src="{{ asset('storage/tts_audio_1742904189.mp3') }}" type="audio/mpeg">
                    </audio>
                    <audio controls class="w-100 mb-2">
                        <source src="{{ asset('storage/tts_audio_1742904213.mp3') }}" type="audio/mpeg">
                    </audio>
                    <audio controls class="w-100 mb-2">
                        <source src="{{ asset('storage/tts_audio_1742904233.mp3') }}" type="audio/mpeg">
                    </audio>
                    <audio controls class="w-100 mb-2">
                        <source src="{{ asset('storage/tts_audio_1742904304.mp3') }}" type="audio/mpeg">
                    </audio>
                    
                       {{-- live --}}
                    {{-- <audio controls class="w-100 mb-2">
                        <source src="{{ asset('storage/tts_audio_1742970696.mp3') }}" type="audio/mpeg">
                    </audio>
                    <audio controls class="w-100 mb-2">
                        <source src="{{ asset('storage/tts_audio_1742970731.mp3') }}" type="audio/mpeg">
                    </audio>
                    <audio controls class="w-100 mb-2">
                        <source src="{{ asset('storage/tts_audio_1742970681.mp3') }}" type="audio/mpeg">
                    </audio>
                    <audio controls class="w-100 mb-2">
                        <source src="{{ asset('storage/tts_audio_1742970713.mp3') }}" type="audio/mpeg">
                    </audio> --}}
            </div>
        </div>
    </div>
</section>
<!-- text to speech Section -->
<section class="tts  d-none">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-baseline w-100">
            <h2 class="text-center fw-bold mb-4 mx-auto">Text to Speech Converter</h2>
        </div>
        <div class="card card-style p-4">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="title" class="form-label font-family">Title</label>
                            <input type="text" id="title" class="form-control shadow-none border-style" placeholder="Enter file name">
                        </div>
                        <div class="col-12 col-md-6 d-grid">
                            <label for="languageDropdown" class="form-label font-family">Language</label>
                            <select id="languageDropdown" class="form-control shadow-none">
                                <option value="h-20" style="30px">Select Language</option>
                            </select>
                        </div>
                    </div>
                </div>
        
        
                <div class="mb-3">
                    <label for="text" class="form-label font-family">Enter Your Text</label>
                    <textarea id="text" class="form-control shadow-none border-style" rows="15" placeholder="Enter text here..."></textarea>
                </div>
                <div class="row row-feature">
                    <div class="d-flex d-flex-feature pb-4 pt-4 align-items-center gap-5 ">
                        <div class="btn-group dropup cursor">
                            <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{asset('image/images.png')}}" alt="" width="40">
                            </div>
                            <div class="dropdown-menu">
                                <div id="voiceList" class="row px-2" style="max-height: 380px; overflow-y: auto;">
                                
                                </div>
                                <input type="hidden" id="selectedVoice">
                            </div>
                        </div>
                        <div class="btn-group dropup d-flex align-items-center gap-2 cursor">
                            <span>
                            <img src="{{asset('image/skating.png')}}" alt=""  width="25">
                            </span>
                            <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Speech Speed
                            </div>
                            <div class="custom-modal dropdown-menu">
                                <h5 class="fw-bold">Normal</h5>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <button class="btn-circle decrease">−</button>
                                        <input type="number" id="rate" name="rate" class="form-control text-center shadow-none" min="-100" max="100" step="1" value="1" style="width: 75px;">
                                        <button class="btn-circle increase">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group dropup gap-2">
                            <span>
                                <img src="{{asset('image/microphone-alt.png')}}" alt=""  width="25">
                            </span>
                            <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Pitch
                            </div>
                            <div class="custom-modal dropdown-menu">
                                <h5 class="fw-bold">Voice Pitch</h5>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <button class="btn-circle decrease">−</button>
                                        <input type="number" id="pitch" name="pitch" class="form-control text-center shadow-none" min="-100" max="100" step="1" value="1" style="width: 75px;">
                                        <button class="btn-circle increase">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group dropup gap-2">
                            <span>
                                <img src="{{asset('image/volume.png')}}" alt=""  width="25">
                            </span>
                            <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Volume
                            </div>
                            <div class="custom-modal dropdown-menu">
                                <h5 class="fw-bold">Volume</h5>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <button class="btn-circle decrease">−</button>
                                        <input type="number" id="volume" name="volume" class="form-control text-center shadow-none" min="-100" max="100" step="1" value="1" style="width: 75px;">
                                        <button class="btn-circle increase">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100" id="convertBtn">Convert to Speech</button>
                    </div>
                </div>
                <div class="mt-3" id="audio-container" style="display: none;">
                    <audio id="audio" controls class="w-100"></audio>
                </div>
            </div>
</div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Why Choose TTSVoiceOver.com?</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="feature-icon">🌍</div>
                <h5>Multilingual TTS</h5>
                <p>Convert text to speech in over 50 languages with natural-sounding voices.</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon">🎙️</div>
                <h5>Realistic AI Voices</h5>
                <p>Choose from male, female, and accented voices to match your content.</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon">📝</div>
                <h5>Audio/Video Transcription</h5>
                <p>Convert audio and video files into accurate text for subtitles or documentation.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">How It Works</h2>
        <div class="row text-center">
            <div class="col-md-3">
                <h5>1. Upload Text or File</h5>
                <p>Paste text or upload audio/video files directly.</p>
            </div>
            <div class="col-md-3">
                <h5>2. Choose Language & Voice</h5>
                <p>Select from 50+ languages and dozens of AI voices.</p>
            </div>
            <div class="col-md-3">
                <h5>3. Customize Settings</h5>
                <p>Adjust speed, pitch, and tone for perfect delivery.</p>
            </div>
            <div class="col-md-3">
                <h5>4. Download & Use</h5>
                <p>Download high-quality audio files or transcripts instantly.</p>
            </div>
        </div>
    </div>
</section>

<!-- Use Cases Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Perfect For</h2>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item">🎥 YouTubers & Video Creators</li>
                    <li class="list-group-item">📣 Marketers & Advertisers</li>
                    <li class="list-group-item">📚 Educators & Trainers</li>
                    <li class="list-group-item">🎙️ Podcasters & Audio Creators</li>
                    <li class="list-group-item">📝 Transcription & Documentation</li>
                </ul>
            </div>
            <div class="col-md-6">
                <p>Whether you're creating **voiceovers for videos**, **multilingual ads**, or need **accurate transcriptions**, TTSVoiceOver.com has you covered with easy-to-use tools and affordable pricing.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section">
    <h2>Start Creating Professional Voiceovers Today!</h2>
    <p class="lead">Experience fast, high-quality text-to-speech & transcription services.</p>
    <a href="{{route('free.tts')}}" class="btn btn-light btn-lg">Get Started Now</a>
</section>

<!-- Footer -->
<footer>
    <p>© 2025 TTSVoiceOver.com | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    <p>Follow Us: 
        <a href="#">Facebook</a> | 
        <a href="#">Twitter</a> | 
        <a href="#">YouTube</a>
    </p>
</footer>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EZV64M4809"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="{{ asset('js/languages.js') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
  
    gtag('config', 'G-EZV64M4809');
  </script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-free', function () {
            $('.tts').toggleClass('d-none');
        });


        $("#languageDropdown").select2({
            placeholder: "Select a language",
            allowClear: true,
            width: '100%'
        });

        $.get('/languages', function (data) {
            $.each(data, function (key, value) {
                $('#languageDropdown').append('<option class="h-50" value="' + key + '">' + value + '</option>');
            });
            $('#languageDropdown').val('en-US').trigger('change');
        });

        $('#languageDropdown').on('change', function () {
            var locale = $(this).val();
            $('#voiceList').empty();

            if (locale) {
                $.get('/voices/' + locale, function (voices) {
                    if (voices.length > 0) {
                        $('#voiceList').empty();
                        $.each(voices, function (index, voice) {
                            let friendlyName = extractVoiceName(voice.friendly_name);
                            let voiceCard = `
                               <div class="col-12 mb-3">
                                    <div class="voice-card p-3 d-flex align-items-center" data-voice="${voice.short_name}">
                                        <div class="voice-img">
                                            <img src="{{asset('image/images.png')}}" alt="${friendlyName}">
                                        </div>
                                        <div class="voice-info ms-3">
                                            <h6 class="name">${friendlyName}</h6>
                                            <span class="badge free">Free</span>
                                        </div>
                                    </div>
                                </div>
                                `;
                            $('#voiceList').append(voiceCard);
                        });

                        let firstVoice = $('.voice-card').first();
                        if (firstVoice.length > 0) {
                            firstVoice.addClass('active');
                            let firstVoiceData = firstVoice.data('voice');
                            console.log("First Voice Selected:", firstVoiceData);
                            $('#selectedVoice').val(firstVoiceData);
                        }
                    }
                });
            }
        });
       

        $(document).on('click', '.voice-card', function() {
            $('.voice-card').removeClass('active');
            $(this).addClass('active');
            let selectedVoice = $(this).data('voice');
            console.log("Selected Voice:", selectedVoice);
            $('#selectedVoice').val(selectedVoice);
        });

        function extractVoiceName(friendlyName) {
            let match = friendlyName.match(/^Microsoft\s+(\w+)/);
            return match ? match[1] : friendlyName;
        }

        $(".custom-modal").click(function (event) {
            event.stopPropagation();
        });

         $(".increase").click(function () {
            let rateInput = $(this).siblings("input");
            let currentValue = parseInt(rateInput.val());
            if (currentValue < 100) {
               rateInput.val(currentValue + 1);
            }
        });

         $(".decrease").click(function () {
           let rateInput = $(this).siblings("input");
           let currentValue = parseInt(rateInput.val());
           if (currentValue > -100) {
             rateInput.val(currentValue - 1);
            }
        });

        function handleAudioAction(saveAudio = false) {
            let text = $("#text").val().trim();
            let project_name = $("#title").val().trim();
            let languageDropdown = $("#languageDropdown").val();
            let voice = $("#selectedVoice").val();
            let pitch = Math.min(100, Math.max(-100, parseFloat($("input[name='pitch']").val()))) + "Hz";
            let rate = Math.min(100, Math.max(-100, parseFloat($("input[name='rate']").val()))) + "%";
            let volume = Math.min(100, Math.max(-100, parseFloat($("input[name='volume']").val()))) + "%";
            let projectid = $("input[name='projectid']").val();

                    if (!text) {
                        toastr.error("Please enter some text");
                        return false; 
                    }

                    if (!project_name) {
                        toastr.error("Please enter a title");
                        return false;
                    }

                    if (!languageDropdown) {
                        toastr.error("Please select a language");
                        return false; 
                    }

                    if (!voice) {
                        toastr.error("Please select a voice");
                        return false; 
                    }

            $("#convertBtn").text("Processing...").prop("disabled", true);

            $.ajax({
                url: "{{ route('generate-text-to-speech') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                contentType: "application/json",
                data: JSON.stringify({
                    text, voice, project_name, saveAudio, pitch, rate, volume, projectid
                }),
                success: function (data) {
                    if (data.status === "success") {
                        toastr.success("Audio processed successfully!");
                        let audioSrc = "data:audio/mpeg;base64," + data.audio_base64;
                        $("#audio").attr("src", audioSrc);
                        $("#audio-container").show();
                        if (saveAudio) {
                            window.location.href = "{{ route('projects.list') }}";
                            toastr.success("Audio Project created successfully!");
                        }
                    } else {
                        toastr.error("Failed to process audio");
                    }
                },
                error: function (jqXHR) {
                    let response = JSON.parse(jqXHR.responseText);
                    toastr.error(response.message || "An error occurred");
                },
                complete: function () {
                    $("#convertBtn").text("Convert to Speech").prop("disabled", false);
                }
            });
        }

        $("#convertBtn").click(() => handleAudioAction(false));
        $("#createAudio").click(() => handleAudioAction(true));

        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if($errors->any()) toastr.error("{{ $errors->first() }}"); @endif
    });
</script>
</body>
</html>
