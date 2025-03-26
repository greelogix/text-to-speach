<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Free Text to Speech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.flaticon.com/path-to-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <div class="container mt-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center w-100 mb-4">
                    <h2 class="text-center fw-bold mb-4 mb-md-0 mx-auto mx-md-0">Text to Speech Converter</h2>
                    <div class="d-flex gap-2">
                        <a href="{{ route('register.form') }}" class="btn btn-success btn-sm">Sign up</a>
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                    </div>
                </div>
            <div class="card p-4">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="title" class="form-label font-family">Title</label>
                                <input type="text" id="title" class="form-control shadow-none border-style" placeholder="Enter file name">
                            </div>
                            <div class="col-12 col-md-6">
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
                    <div class="mt-3" id="audio-container" style="display: none;">
                        <audio id="audio" controls class="w-100"></audio>
                    </div>
                </div>
 </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="{{ asset('js/languages.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#languageDropdown").select2({
            placeholder: "Select a language",
            allowClear: true,
            width: '100%',
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