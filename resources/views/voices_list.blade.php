@extends('layouts.main')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@section('content')
<style>
    nav .text-muted{
    color: white !important;
   }
   .select2-dropdown {
    z-index: 9999 !important;
   }
</style>
<body class="bg-light">
    <div class="container mt-4">
        <h3 class="mb-3 ">{{$project->project_name}} <i class="bi bi-pencil"></i></h3>
        <div class="d-flex justify-content-between align-items-baseline">
            <p class=""><a href="{{route('projects.list')}}" class=" text-dark text-decoration-none">Project</a> > My Projects (Voices)</p>
            <div class="mt-4 action-buttons">
                <button type="button" data-bs-toggle="modal" data-bs-target="#AddVoiceModal" class="btn text-white add-voice-btn bg-success border-0"  data-project-id="{{$project->id}}" style="height: 35px;font-size: small;">+ Audio file</button>
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
                <div class="container mt-4">
                    <h2 class="text-center fw-bold mb-4">Text to Speech Converter</h2>
                    <div class="p-4">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" class="form-control shadow-none"  placeholder="Enter file name">
                        </div>
                        <input type="hidden" class="project_id" id="project-id">
                        <div class="mb-3">
                            <label for="text" class="form-label">Enter Your Text</label>
                            <textarea id="text" class="form-control shadow-none" rows="15" placeholder="Enter text here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="lang" class="form-label">Select Language:</label>
                            <select id="lang" class="form-select" style="width: 100%;">
                                <option value="">Loading languages...</option>
                            </select>        
                        </div>
                        <button class="btn w-100 text-white" id="convertBtn" style="background: #ff7eb3">Convert to Speech</button>
                        <div class="mt-3" id="audio-container" style="display: none;">
                            <audio id="audio" controls class="w-100"></audio>
                        </div>
                        <div class="row pt-3">
                            <div class="col text-end">
                                <button type="button" class="btn custom-cancel text-dark border-danger" data-bs-dismiss="modal" style="background: transparent;font-size: smaller;">Cancel</button>
                                <button type="button" class="btn custom-create text-white bg-success border-0" id="createAudio" style="font-size: smaller;">Create Audio</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="{{ asset('js/languages.js') }}"></script>
   <script>
        $(document).ready(function() {
            $('.add-voice-btn').on('click', function () {
                var projectId = $(this).data('project-id');
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

        });

    $(document).ready(function () {
            $("#lang").select2({
                placeholder: "Select a language",
                allowClear: true,
            });
            fetchLanguages();
        function handleAudioAction(saveAudio = false, fetchProjectId = false) {
            let text = $("#text").val().trim();
            let project_name = $("#title").val().trim();    
            let lang = $("#lang").val();
            let projectid = fetchProjectId ? $('.project_id').val() : null;

            if (!text) {
                toastr.error("Please enter some text");
                return false; 
            }

            if (!project_name) {
                toastr.error("Please enter a title");
                return false;
            }

            if (!lang) {
                toastr.error("Please select a language");
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
                data: JSON.stringify({ text: text, lang: lang, project_name: project_name, projectid: projectid, saveAudio: saveAudio  }),
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
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                    toastr.error("Something went wrong! " + jqXHR.responseText);
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
            handleAudioAction(true, true); 
        });
    });
</script>
</body>
@endsection
