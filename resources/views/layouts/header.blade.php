@php
// $user = auth_user();
$user = Auth::user();
@endphp
<style>
@media (max-width: 1024px) {
      .medium-screen-nav span:first-child,.Profile-Image {
      display: none;
  }
}

@media (min-width: 1025px) {
  .medium-screen-nav span:last-child {
      display: none;
  }
}
</style>
    <div class="container-fluid d-flex flex-md-row flex-sm-row justify-content-between align-items-center shadow p-3 bg-body">
        <div style="position: relative; left: 15px;">
            <h5>Dashboard</h5>
        </div>
        <div class="d-flex align-items-center gap-3  flex-row" style="position: relative; right: 15px;">
                <img src="{{ $user->image ? Storage::url($user->image) : asset('logo/default-profile.jpg') }}" 
                class="rounded-circle border Profile-Image" 
                alt="Profile Image" 
                style="height: 35px; width: 35px;">
           <div class="dropdown">
            <button class="dropdown-toggle text-black d-flex" 
                    id="dropdownMenuButton1" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false" 
                    style="border: none; background: none;">
                    <p class="medium-screen-nav">
                        <span>{{ $user->name }}</span>
                        <span><i class="fa-solid fa-bars"></i></span>
                    </p> 
            </button>
               <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="min-width: 250px;">
                <li>
                    <a class="dropdown-item cursor-pointer" data-bs-toggle="modal" data-bs-target="#profileModal">
                        <i class="fas fa-user me-2 text-dark"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2 text-dark"></i> Logout
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects.list') }}" class="d-block px-3 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                        <i class="fas fa-home me-2 text-dark"></i> 
                        <span class="sidebar-text text-dark">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('generate_speech_page') }}" class="d-block px-3 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                        <i class="fa-solid fa-language me-2 text-dark"></i>
                        <span class="sidebar-text text-dark">Text to Speech</span>
                    </a>
                </li>
                
               </ul>
            </div>
        </div>
    </div>
  <!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content shadow-lg border-0">
            <!-- Modal Header -->
            <div class="modal-header btn-purple  text-white">
                <h5 class="modal-title ms-4 fw-bold" id="profileModalLabel">Profile</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body bg-light">
                <div class="row">
                    <!-- Profile Details Section -->
                    <div class="col-md-4 p-4 text-center bg-white rounded shadow-sm">
                        <h6 class="fw-bold mb-4" style="color: #7f56d9;">Profile Details</h6>
                        <img src="{{ $user->image ? Storage::url($user->image) : asset('logo/default-profile.jpg') }}" id="preview" alt="Profile Image" class="img-fluid rounded-circle border mb-3 shadow" style="width: 150px; height: 150px;">
                        <p class="mb-2"><strong>Name:</strong> <span class="text-muted">{{ $user->name }}</span></p>
                        <p><strong>Email:</strong> <span class="text-muted">{{ $user->email }}</span></p>
                    </div>

                    <!-- Edit Profile Section -->
                    <div class="col-md-8 p-4 bg-white rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold" style="color: #7f56d9;">Edit Profile</h6>
                            <i class="fa-solid fa-pen-to-square text-primary cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to edit your profile" id="edit-icon"></i>
                        </div>
                        <form action="{{ route('profile.update', [ $user->id]) }}" method="POST" enctype="multipart/form-data" class="needs-validation">
                            @csrf
                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control shadow-sm" id="name" name="name" value="{{ old('name', $user->name) }}" readonly>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control shadow-sm" id="email" name="email" value="{{ old('email', $user->email) }}" readonly>
                                @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Profile Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Image</label>
                                <input type="file" class="form-control shadow-sm" id="image" name="image" readonly>
                                @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control shadow-sm" id="password" name="password" value="{{ old('password') }}" readonly>
                                @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Update Button -->
                            <button type="submit" id="updatebtn" class="btn btn-purple d-none text-white"  style="font-size: small; background: linear-gradient(to right, #6a11cb, #2575fc);">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#edit-icon').click(function() {
            $('#name, #email, #password').removeAttr('readonly');
            $('#updatebtn').removeClass('d-none');
        });
        $('#profileModal').on('hidden.bs.modal', function () {
            $('#name, #email, #password').attr('readonly', 'readonly');
            $('#updatebtn').addClass('d-none');
        });

        $('#image').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
