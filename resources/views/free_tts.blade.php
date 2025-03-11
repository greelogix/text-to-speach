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
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-baseline w-100">
            <h2 class="text-center fw-bold mb-4 mx-auto">Text to Speech Converter</h2>
            <div>
                <a href="{{ route('register.form') }}" class="btn btn-success btn-sm">Sign up</a>
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
            </div>
           
        </div>
            
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
        </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.responsivevoice.org/responsivevoice.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/languages.js') }}"></script>
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
                            console.log(data);
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
                            
                            if (jqXHR.status == 403) {
                                toastr.error("Free limit reached! Please Sign up to continue.");
                                // setTimeout(function() {
                                //     window.location.href = "{{ route('register.form') }}";
                                // }, 2000);
                            } else {
                                toastr.error("Something went wrong! " + jqXHR.responseText);
                            }
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

            @if(session('success')) toastr.success("{{ session('success') }}"); @endif
            @if($errors->any()) toastr.error("{{ $errors->first() }}"); @endif
        </script>
</body>
</html>

