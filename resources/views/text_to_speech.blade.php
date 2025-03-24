@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center fw-bold mb-4">Text to Speech Converter</h2>
        <div class="card p-4">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" class="form-control shadow-none" placeholder="Enter file name">
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Enter Your Text</label>
                <textarea id="text" class="form-control shadow-none" rows="15" placeholder="Enter text here..."></textarea>
            </div>
            <div class="mb-3">
                <select id="languageDropdown" class="form-select">
                    <option value="">Select Language</option>
                </select>
            </div>
                <div class="col-12 d-flex pb-4 pt-4 align-items-center gap-5">
                    <div class="btn-group dropup">
                        <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{asset('image/images.png')}}" alt="" width="40">
                        </div>
                        <div class="dropdown-menu">
                            <div id="voiceList" class="row px-2" style="max-height: 380px; overflow-y: auto;">
                            
                            </div>
                            <input type="hidden" id="selectedVoice">
                        </div>
                    </div>

                  <div class="btn-group dropup d-flex align-items-center gap-2">
                    <span><i class="fa-solid fa-gauge" style="font-size: xx-large;"></i></span>
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
                            <div class="slider-container">
                                <div class="custom-slider">
                                    <div class="slider-thumb"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="btn-group dropup">
                    <i class="fa-solid fa-wave-sine"></i>
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
                            <div class="slider-container">
                                <div class="custom-slider">
                                    <div class="slider-thumb"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group dropup">
                    <i class="fa-solid fa-wave-sine"></i>
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
                            <div class="slider-container">
                                <div class="custom-slider">
                                    <div class="slider-thumb"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary w-100" id="convertBtn">Convert to Speech</button>
            <div class="mt-3" id="audio-container" style="display: none;">
                <audio id="audio" controls class="w-100"></audio>
            </div>
            <div class="row pt-3">
                <div class="col text-end">
                    <button class="btn btn-color text-white" id="createAudio" style="background: green;">
                        Create Audio
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // $(document).ready(function () {
    //     $("#lang").select2({
    //             placeholder: "Select a language",
    //             allowClear: true
    //     });

    //      fetchLanguages();
    //     function handleAudioAction(saveAudio = false) {
    //         let text = $("#text").val().trim();
    //         let project_name = $("#title").val().trim();    
    //         let lang = $("#lang").val();

    //         if (!text) {
    //             toastr.error("Please enter some text");
    //             return false; 
    //         }

    //         if (!project_name) {
    //             toastr.error("Please enter a title");
    //             return false;
    //         }

    //         if (!lang) {
    //             toastr.error("Please select a language");
    //             return false; 
    //         }
    //             $("#convertBtn").text("Processing...").prop("disabled", true);
    //         $.ajax({
    //             url: "{{ route('generate-text-to-speech') }}",
    //             type: "POST",
    //             headers: {
    //                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    //             },
    //             contentType: "application/json",
    //             data: JSON.stringify({ text: text, lang: lang, project_name: project_name, saveAudio: saveAudio }),
    //             success: function (data) {
    //                 if (data.status === "success") {
    //                     toastr.success("Audio processed successfully!");
    //                     let audioSrc = "data:audio/mpeg;base64," + data.audio_base64;
    //                     $("#audio").attr("src", audioSrc); 
    //                     $("#audio-container").show(); 
    //                     if (saveAudio) {
    //                         window.location.href = "{{ route('projects.list') }}";
    //                         toastr.success("Audio Project create successfully!");
    //                     }
    //                 } else {
    //                     toastr.error("Failed to process audio");
    //                 }
    //             },
    //             error: function (jqXHR, textStatus, errorThrown) {
    //                 console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
    //                 toastr.error("Something went wrong! " + jqXHR.responseText);
    //             },

    //             complete: function () {
    //                 $("#convertBtn").text("Convert to Speech").prop("disabled", false);
    //             }
    //         });
    //     }

    //     $("#convertBtn").click(function () {
    //         handleAudioAction(false); 
    //     });
    //     $("#createAudio").click(function () {
    //         handleAudioAction(true); 
    //     });
    // });

    $(document).ready(function () {
        $("#languageDropdown").select2({
            placeholder: "Select a language",
            allowClear: true
        });

        $.get('/languages', function (data) {
            $.each(data, function (key, value) {
                $('#languageDropdown').append('<option value="' + key + '">' + value + '</option>');
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
                                <div class="col-12 mb-2">
                                    <div class="voice-card p-3 text-center" data-voice="${voice.short_name}" style="border-radius: 10px; cursor: pointer;">
                                        <img src="{{asset('image/images.png')}}" alt="${friendlyName}" width="40">
                                        <p class="free">Free</p>
                                        <h6 class="name">${friendlyName}</h6>
                                    </div>
                                </div>`;
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
@endsection
