@extends('layouts.main')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/style.css">
@section('content')
<style>
    nav .text-muted{
    color: white !important;
   }
   .select2-dropdown {
    z-index: 9999 !important;
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
.slider-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 15px;
}
.custom-slider {
  width: 20px;
  height: 120px;
  background: #f0f0f0;
  border-radius: 20px;
  position: relative;
  display: flex;
  align-items: flex-end;
  padding: 5px;
}
.slider-thumb {
  width: 20px;
  height: 50px;
  background: #6a49ff;
  border-radius: 10px;
  position: absolute;
  bottom: 2px;
  left: 0px;
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
@media (max-width: 1024px) { 
  .sidebar-style {
    display: none;
  }
}
</style>
<body class="bg-light">
    <div class="container mt-4">
        <h3 class="mb-3 ">{{$project->project_name}} <i class="bi bi-pencil"></i></h3>
        <div class="d-flex justify-content-between align-items-baseline">
            <p class=""><a href="{{route('projects.list')}}" class=" text-dark text-decoration-none">Project</a> > My Projects (Voices)</p>
            <div class="mt-4 action-buttons">
                <button type="button" data-bs-toggle="modal" data-bs-target="#AddVoiceModal" class="btn text-white add-voice-btn bg-success border-0"  data-project-id="{{ $project->id }}" style="height: 50px;font-size: small;">+ Audio file</button>
            </div>
        </div>
        <div class="row">
            @if($voices->count() > 0)
                @foreach ($voices as $voice)
                    <div class="col-md-3 pt-3 pb-3">
                        <div class="project-card card p-3 pb-0 voice-card shadow" style="border: 5px solid #c0b9d0c4; cursor: pointer;">
                            <div class="text-center">
                                <img src="{{asset('image/audio_file.png')}}" alt="" width="80px">
                            </div>
                            <div class="d-flex justify-content-between pt-3">
                                <div class="play-audio">
                                    <h6 class="play-audio-icon">{{$voice->title ?? 'N\A'}} <i class="fa-solid fa-circle-play"></i></h6>
                                    <audio controls class="d-none voices-audio" src="data:audio/mpeg;base64,{{ $voice->text_to_audio }}" type="audio/mpeg"></audio>
                                </div>
                                <div class="dropdown position-relative">
                                    <button class="btn-light btn-sm border-0 rounded" style="font-size:medium; background: none;" 
                                            id="dropdownMenuButton1" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false" >
                                            <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $voice->id }}').submit();">
                                                Delete Voice
                                            </a>
                                        
                                            <form id="delete-form-{{ $voice->id }}" action="{{ route('delete_voice', $voice->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p style="font-size: small;"><i class="fa-solid fa-calendar-days"></i> {{ \Carbon\Carbon::parse($voice->updated_at)->format('d/m/Y') }}</p>
                                <p style="font-size: small;"><i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($voice->updated_at)->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center mt-5">
                    <p class="fs-5 fw-lighter text-white">No voices found for this project.</p>
                </div>
            @endif

            {{ $voices->links('pagination::bootstrap-5') }}

            <div id="global-audio-container" class="text-center mt-3 d-none">
                <audio id="global-audio" class="w-100" controls>
                    <source id="audio-source" src="" type="audio/mpeg">
                </audio>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="AddVoiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-center fw-bold">Text to Speech Converter</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
                <div class="container mt-4">
                    <div class="p-4">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <label for="title" class="form-label font-family">Title</label>
                                    <input type="text" id="title" class="form-control shadow-none border-style" placeholder="Enter file name">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="languageDropdown" class="form-label font-family">Language</label>
                                    <select id="languageDropdown" class="form-control shadow-none">
                                        <option value="h-20" style="30px">Select Language</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label font-family">Enter Your Text</label>
                                <textarea id="text" class="form-control shadow-none" rows="15" placeholder="Enter text here..."></textarea>
                            </div>
                            <input type="hidden" class="project_id" id="project-id">
                            {{-- <div class="mb-3">
                                <select id="languageDropdown" class="form-select" style="width: 100%">
                                    <option value="">Select Language</option>
                                </select>
                            </div>                             --}}
                            <div class="row">
                                <div class="d-flex flex-wrap pb-4 pt-4 align-items-center gap-3 justify-content-center">
                                    <div class="btn-group dropup">
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="{{asset('image/images.png')}}" alt="" width="40">
                                        </div>
                                        <div class="dropdown-menu">
                                            <div id="voiceList" class="row px-2" style="max-height: 380px; overflow-y: auto;"></div>
                                            <input type="hidden" id="selectedVoice">
                                        </div>
                                    </div>
                            
                                    <div class="btn-group dropup d-flex align-items-center gap-2">
                                        <span>
                                           <img src="{{asset('image/skating.png')}}" alt="" width="25">
                                        </span>
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Speech Speed
                                        </div>
                                        <div class="custom-modal dropdown-menu">
                                            <h5 class="fw-bold">Normal</h5>
                                            <div class="d-flex justify-content-around">
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    <button class="btn-circle decrease">−</button>
                                                    <input type="number" id="rate" name="rate" class="form-control text-center shadow-none"
                                                        min="-100" max="100" step="1" value="1" style="width: 75px;">
                                                    <button class="btn-circle increase">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="btn-group dropup d-flex align-items-center gap-2">
                                        <span>
                                            <img src="{{asset('image/microphone-alt.png')}}" alt="" width="25">
                                        </span>
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Pitch
                                        </div>
                                        <div class="custom-modal dropdown-menu">
                                            <h5 class="fw-bold">Voice Pitch</h5>
                                            <div class="d-flex justify-content-around">
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    <button class="btn-circle decrease">−</button>
                                                    <input type="number" id="pitch" name="pitch" class="form-control text-center shadow-none"
                                                        min="-100" max="100" step="1" value="1" style="width: 75px;">
                                                    <button class="btn-circle increase">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="btn-group dropup d-flex align-items-center gap-2">
                                        <span>
                                            <img src="{{asset('image/volume.png')}}" alt="" width="25">
                                        </span>
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Volume
                                        </div>
                                        <div class="custom-modal dropdown-menu">
                                            <h5 class="fw-bold">Volume</h5>
                                            <div class="d-flex justify-content-around">
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    <button class="btn-circle decrease">−</button>
                                                    <input type="number" id="volume" name="volume" class="form-control text-center shadow-none"
                                                        min="-100" max="100" step="1" value="1" style="width: 75px;">
                                                    <button class="btn-circle increase">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-2">
                                        <select id="pause" class="form-control shadow-none">
                
                                        </select>
                                    </div>    
                                </div>
                            
                                <!-- Buttons Container -->
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <button class="btn btn-primary flex-fill m-1" id="convertBtn">Convert to Speech</button>
                                    <button class="btn btn-color text-white flex-fill m-1" id="createAudio" style="background: green;">Create Audio</button>
                                </div>
                            </div>
                            </div>
                            <div class="mt-3" id="audio-container" style="display: none;">
                                <audio id="audio" controls class="w-100"></audio>
                            </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="{{ asset('js/languages.js') }}"></script>
   <script>
        $(document).ready(function() {
            let pauseSelect = $("#pause");
            let textArea = $("#text");

            pauseSelect.html('<option value="">Add Pause</option>'); 
            for (let i = 0.5; i <= 4; i += 0.5) {
                pauseSelect.append(`<option value="[${i}s]">${i} sec</option>`);
            }

            pauseSelect.on("change", function () {
                let pauseText = $(this).val();
                if (pauseText) {
                    let cursorPos = textArea.prop("selectionStart");
                    let text = textArea.val();
                    let newText = text.substring(0, cursorPos) + pauseText + text.substring(cursorPos);
                    textArea.val(newText);
                    $(this).val("");
                }
            });

            $("#pause").select2({
                placeholder: "Add Pause",
                allowClear: true,
                width: '100%'
            });

            $('.add-voice-btn').on('click', function () {
                var projectId = $(this).data('project-id');
                console.log(projectId)
                $('.project_id').val(projectId);
            });

            $(".play-audio").on("click", function(e) {
                e.stopPropagation();
                let audioSrc = $(this).closest(".play-audio").find(".voices-audio").attr("src");
                if (audioSrc) {
                    $("#audio-source").attr("src", audioSrc);
                    $("#global-audio")[0].load();
                    $("#global-audio")[0].play();
                    $("#global-audio-container").removeClass("d-none");
                }
            });

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

        function handleAudioAction(saveAudio = false, fetchProjectId = false) {
            let text = $("#text").val().trim();
            let project_name = $("#title").val().trim();
            let languageDropdown = $("#languageDropdown").val();
            let voice = $("#selectedVoice").val();
            let pitch = Math.min(100, Math.max(-100, parseFloat($("input[name='pitch']").val()))) + "Hz";
            let rate = Math.min(100, Math.max(-100, parseFloat($("input[name='rate']").val()))) + "%";
            let volume = Math.min(100, Math.max(-100, parseFloat($("input[name='volume']").val()))) + "%";
            let projectid = fetchProjectId ? $('#project-id').val() : null; 

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
                if(fetchProjectId){
                    $("#createAudio").text("Processing...").prop("disabled", true);
                }else{
                    $("#convertBtn").text("Processing...").prop("disabled", true);
                }
              

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
                        console.log(data);
                        toastr.success("Audio processed successfully!");
                        let audioSrc = "data:audio/mpeg;base64," + data.audio_base64;
                        $("#audio").attr("src", audioSrc); 
                        $("#audio-container").show(); 
                        $('#AddVoiceModal').modal('show');
                        if(data.update_voice === "update_voice"){
                        $('#AddVoiceModal').modal('hide');
                         setTimeout(function() { 
                            location.reload();
                        }, 1000); 
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

        $("#convertBtn").click(function () {
            handleAudioAction(false, false); 
        });

        $("#createAudio").click(function () {
            handleAudioAction(false, true); 
        });

        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if($errors->any()) toastr.error("{{ $errors->first() }}"); @endif
    });

</script>
</body>
@endsection
