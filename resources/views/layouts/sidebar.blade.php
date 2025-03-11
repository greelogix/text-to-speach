<div class="sidebar ">
    <div class="text-white h-100 rounded-3">
        <ul class="list-unstyled pt-2">
            <li class="pt-4">
                <a href="{{ route('projects.list') }}" class="d-block px-4  py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-home me-2 text-dark"></i> 
                    <span class="sidebar-text text-dark">Dashboard</span>
                </a>
            </li>
            <li class="pt-2">
                <a href="{{ route('generate_speech_page') }}" class="d-block px-4  py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fa-solid fa-language me-2 text-dark"></i>
                    <span class="sidebar-text text-dark">Text to Speech</span>
                </a>
            </li>
        </ul>        
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ProjectModal" tabindex="-1" aria-labelledby="ProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold mx-auto project_ce">Create Project</h5>
            </div>
            <form action="{{route('projects.store')}}" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="project_id">
                    <input type="text" id="project_name" class="form-control custom-input shadow-none project_name" name="project_name" placeholder="Enter project name">
                    <small class="text-danger" id="error-message"></small>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-end">
                    <button type="button" class="btn custom-cancel" data-bs-dismiss="modal" style=" border: 1px solid red;color: #906cf3;background: transparent;color: black;border-radius: 8px;padding: 6px 16px;">Cancel</button>
                    <button type="button" class="btn custom-create project-btn" id="createProject" style=" background-color: green;color: white;border-radius: 8px;padding: 8px 16px;border: none;">Create Project</button>
                </div>
        </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#createProject').click(function() {
            let projectName = $('#project_name').val();
            let projectid = $('.project_id').val();
            let errorMessage = $('#error-message');
            errorMessage.text('');
            $.ajax({
                url: "{{route('projects.store')}}",
                type: 'POST',
                data: {
                    projectid:projectid,
                    project_name: projectName,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.success);
                    $('#ProjectModal').modal('hide');
                    setTimeout(function() { 
                        location.reload();
                    }, 1000);  
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors && errors.project_name) {
                        errorMessage.text(errors.project_name[0]);
                    } else {
                        errorMessage.text('Something went wrong!');
                    }
                }
            });
        });

        $('.create-project').on('click',function(){
                 $('.project_id').val('');
                $('.project_name').val('');
                $('.project_ce').text('Create Project');
                $('.project-btn').text('Create Project');
        });
    });
</script>
