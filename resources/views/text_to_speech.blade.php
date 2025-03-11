@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center fw-bold mb-4">Text to Speech Converter</h2>
        <div class="card p-4">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" class="form-control shadow-none"  placeholder="Enter file name">
            </div>
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
    <script>
    $(document).ready(function () {
        $("#lang").select2({
                placeholder: "Select a language",
                allowClear: true
        });

         fetchLanguages();
        function handleAudioAction(saveAudio = false) {
            let text = $("#text").val().trim();
            let project_name = $("#title").val().trim();    
            let lang = $("#lang").val();

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
                data: JSON.stringify({ text: text, lang: lang, project_name: project_name, saveAudio: saveAudio }),
                success: function (data) {
                    if (data.status === "success") {
                        toastr.success("Audio processed successfully!");
                        let audioSrc = "data:audio/mpeg;base64," + data.audio_base64;
                        $("#audio").attr("src", audioSrc); 
                        $("#audio-container").show(); 
                        if (saveAudio) {
                            window.location.href = "{{ route('projects.list') }}";
                            toastr.success("Audio Project create successfully!");
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
            handleAudioAction(false); 
        });
        $("#createAudio").click(function () {
            handleAudioAction(true); 
        });
    });

</script>
@endsection
