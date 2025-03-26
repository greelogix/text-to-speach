@extends('layouts.main')
@section('content')
<style>
    nav .text-muted{
    color: black !important;
   }
   @media (max-width: 1024px) { 
  .sidebar-style {
    display: none;
  }
}
</style>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h5 class="text-dark" style="font-size: xx-large; font-family: none;">My Projects</h5>
            <button type="button" class="btn btn-color text-white create-project bg-success border-0" style="height: 35px;font-size: small;" data-bs-toggle="modal" data-bs-target="#ProjectModal">
                + Add Project
            </button>
        </div>
        <div class="row mt-5">
        @if ($projects->count() > 0)
            @foreach ($projects as $project)
            <div class="col-lg-3 col-md-6 col-sm-12" style="cursor: pointer;">
                <a href="{{ route('voices.index', ['project_id' => $project->id]) }}" class="text-decoration-none text-dark">
                <div class="card card-folder p-3 mb-4 shadow-sm border-0">
                    <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="icon-folder"><img src="{{asset('image/folder_icon.png')}}" alt="" width="70px"></div>
                        <div class="ms-1 mt-3">
                            <h6 class="mb-0 fs-6">{{$project->project_name}}</h6>
                            <small style="color:gray;font-size: 13px;">{{ $project->voices_count }} Files</small>
                        </div>
                    </div>
                        <div class="dropdown position-relative d-none"  style="bottom: 30px;">
                            <button class="btn btn-light btn-sm" style="font-size:larger" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item text-danger" href="#">Edit Project</a></li>
                                    <li><a class="dropdown-item text-green" href="#">Delete Project</a></li>
                                </ul>
                        </div>
                        <div class="dropdown position-relative"  style="bottom: 20px;">
                            <button class="btn-light btn-sm border-0 rounded " style="font-size:medium; background: none;" 
                                    id="dropdownMenuButton1" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false" >
                                    <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><button class="dropdown-item text-green project_edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ProjectModal"  
                                    data-project-id="{{ $project->id }}" 
                                    data-project-name="{{ $project->project_name }}">
                                Edit Project
                            </button></li>
                                <li>
                                    <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $project->id }}').submit();">
                                        Delete Project
                                    </a>
                                    <form id="delete-form-{{ $project->id }}" action="{{ route('delete_project', $project->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            @endforeach
                {{ $projects->links('pagination::bootstrap-5') }}
        @else
        <div class="text-center mt-5">
            <p class="fs-5 fw-lighter text-white">Project not found</p>
        </div>
        @endif
    </div>

        <h5 class="mt-5 text-dark" style="font-size: xx-large; font-family: none;">Recent Files (8)</h5>
        <div class="row mt-3">
            @if ($recent_voices->count() > 0)
            @foreach ($recent_voices as $voice)
            <div class="col-lg-3 col-md-6 col-sm-12 pb-3">
                <div class="card card-file p-3 shadow-sm border-0" style="cursor: pointer;">
                    <div class="file-icon d-flex gap-2 justify-content-between">
                        <div class="d-flex gap-2 card-voice">
                            <img src="{{asset('image/audio_file.png')}}" alt="" width="75px">
                            <audio controls class="d-none voices-audio" src="data:audio/mpeg;base64,{{ $voice->text_to_audio }}" type="audio/mpeg"></audio>
                            <div>
                                <h6 class="mt-3 mb-3"> {{$voice->title ?? 'N/A'}} </h6>
                                <small>⏱ 0:00</small>
                            </div>
                        </div>
                        <div class="dropdown position-relative d-none">
                            <button class="btn btn-light btn-sm" style="font-size:medium" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item text-green" href="#">Edit Project</a></li>
                                    <li><a class="dropdown-item  text-danger" href="#">Delete Project</a></li>
                                </ul>
                            </ul>
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
                </div>
            </div>
            @endforeach
           @else
                <div class="text-center mt-5">
                    <p class="fs-5 fw-lighter text-white">Voices not found</p>
                </div>
            @endif
            <div id="global-audio-container" class="text-center mt-3 d-none">
                <audio id="global-audio" class="w-100" controls>
                    <source id="audio-source" src="" type="audio/mpeg">
                </audio>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
<script>
        $(document).ready(function() {
            $('.project_edit').on('click', function() {
                var projectId = $(this).data('project-id');
                var projectName = $(this).data('project-name');
                $('.project_id').val(projectId);
                $('.project_name').val(projectName);
                $('.project_ce').text('Update Project');
                $('.project-btn').text('Update Project');
                
            });

           $(".card-voice").on("click", function(e) {
                e.stopPropagation();
                let audioSrc = $(this).find(".voices-audio").attr("src");
                if (audioSrc) {
                    $("#audio-source").attr("src", audioSrc);
                    $("#global-audio")[0].load();
                    $("#global-audio")[0].play();
                    $("#global-audio-container").removeClass("d-none");
                }
            });
        });
</script>
@endsection
