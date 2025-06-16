@extends('layouts.admin')

@section('title')
    Aplikasi
@endsection

@section('container')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="settings"></i></div>
                                Ubah Aplikasi
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                           
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-7">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Informasi Aplikasi</div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show hide-alert" role="alert">
                                    {{ session('success') }}
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('apps.update', $item->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name)-->
                                    <div class="col-md-12">
                                        <label class="small mb-1" for="name">Nama Aplikasi</label>
                                        <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" value="{{ $item->name }}"  required/>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message; }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Form Group (email address)-->
                                <div class="mb-3">
                                    <div class="col-md-12">
                                        <label class="small mb-1" for="title">Judul Aplikasi</label>
                                        <input class="form-control @error('title') is-invalid @enderror" name="title" type="title" value="{{ $item->title }}" required/>
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message; }}
                                            </div>
                                        @enderror
                                    </div>   
                                </div>
                                <div class="mb-3">
                                    <div class="col-md-12">
                                        <label class="small mb-1" for="description">Deskripsi</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" required>{{ $item->description }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message; }}
                                            </div>
                                        @enderror
                                    </div>   
                                </div>
                                <div class="mb-3">
                                    <div class="col-md-12">
                                        <label class="small mb-1" for="link_web">Link Website</label>
                                        <input class="form-control @error('link') is-invalid @enderror" name="link_web" type="link_web" value="{{ $item->link_web }}" required/>
                                        @error('link_web')
                                            <div class="invalid-feedback">
                                                {{ $message; }}
                                            </div>
                                        @enderror
                                    </div>   
                                </div>
                                <!-- Submit button-->
                                <button class="btn btn-primary" type="submit">
                                    Ubah Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Logo Aplikasi</div>
                        <div class="card-body">
                            @if (session()->has('success-logo'))
                                <div class="alert alert-success alert-dismissible fade show hide-alert" role="alert">
                                    {{ session('success-logo') }}
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('logo-apps.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        @if ($item->logo != NULL)
                                            <img id="preview-img" src="{{ Storage::url($item->logo) }}" class="img-fluid rounded mb-2" alt="Preview Image" style="width: 165px;">
                                        @else
                                            <img id="preview-img" src="/admin/assets/img/empty-image.jpg" class="img-fluid rounded mb-2" alt="Preview Image" style="width: 165px;">
                                        @endif
                                    </div>
                                    <div class="col-9">
                                        <input type="file" class="form-control" name="logo" id="logo" accept="image/*">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary mb-2">Ubah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">Logo Favicon</div>
                        <div class="card-body">
                            @if (session()->has('success-favicon'))
                                <div class="alert alert-success alert-dismissible fade show hide-alert" role="alert">
                                    {{ session('success-logo') }}
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('favicon-apps.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        @if ($item->favicon != NULL)
                                            <img id="preview-favicon" src="{{ Storage::url($item->favicon) }}" class="img-fluid rounded mb-2" alt="Preview Image" style="width: 75px;">
                                        @else
                                            <img id="preview-favicon" src="/admin/assets/img/empty-image.jpg" class="img-fluid rounded mb-2" alt="Preview Image" style="width: 75px;">
                                        @endif
                                    </div>
                                    <div class="col-9">
                                        <input type="file" class="form-control" name="favicon" id="favicon" accept="image/*">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary mb-2">Ubah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('addon-script')
  <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); 
        }
    }

    function readURLFavicon(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview-favicon').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); 
        }
    }

    $("#logo").change(function() {
        readURL(this);
    });

    $("#favicon").change(function() {
        readURLFavicon(this);
    });

    window.setTimeout(() => {
        $(".hide-alert").fadeTo(500, 0).slideUp(300, () => {
            $(this).remove(); 
        });
    }, 4000);
  </script>
@endpush

