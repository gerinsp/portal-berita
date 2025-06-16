@extends('layouts.admin')

@section('title')
   Ubah Pos
@endsection

@section('container')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="file-text"></i></div>
                                Ubah Pos
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary" href="{{ route('post.index') }}">
                                <i class="me-1" data-feather="arrow-left"></i>
                                Kembali Ke Semua Pos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            {{-- Alert --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
            <form action="{{ route('post.update', $item->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row gx-4">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">Form Post</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="post_title">Judul</label>
                                    <input type="text" class="form-control @error('post_title') is-invalid @enderror" value="{{ $item->post_title }}" name="post_title" placeholder="Ubahkan Judul.." required>
                                    @error('post_title')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="post_title">Teaser</label>
                                    <textarea name="post_teaser" class="form-control">{{ $item->post_teaser }}</textarea>
                                </div>
                                <div class="mb-0">
                                    <label for="post_content">Konten</label>
                                    <textarea class="form-control" name="post_content" id="full-featured">
                                        {{ $item->post_content }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-header-actions mb-4">
                            <div class="card-header">
                                Kategori
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="categories_id">Kategori</label>
                                    <select class="form-control cat" id="category" name="categories_id" required>
                                        <option>Pilih..</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $item->categories_id == $category->id ? 'selected':'' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="subcategory">Sub Kategori</label>
                                    <select class="form-control cat" id="subcategory" name="sub_categories">
                                        @foreach ($sub_categories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ $item->sub_categories == $subcategory->id ? 'selected':'' }}>{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card card-header-actions mb-4">
                            <div class="card-header">
                                Tags
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <select class="form-select tag-multiple" multiple data-placeholder="Pilih.." name="tags[]" data-allow-clear="1">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}"
                                                @foreach ($item->tag as $post)
                                                    @if ($tag->id == $post->id)
                                                        selected
                                                    @endif
                                                @endforeach
                                            >
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card card-header-actions mb-4">
                            <div class="card-header">
                                Thumbnail
                            </div>
                            <div class="card-body">
                                @if ($item->post_image != NULL)
                                    <img id="preview-img" src="{{ Storage::url($item->post_image) }}" class="img-fluid rounded mb-2" alt="Preview Image" style="height: 165px;">
                                @else
                                    <img id="preview-img" src="/admin/assets/img/empty-image.jpg" class="img-fluid rounded mb-2" alt="Preview Image" style="height: 165px;">
                                @endif
                                <div class="mb-3">
                                    <label for="post-image">Pilih Foto</label>
                                    <input type="file" id="post-image" name="post_image" class="form-control" accept="image/*">
                                    @error('post_image')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="post-image">Deskripsi Foto</label>
                                    <textarea name="post_image_description" class="form-control @error('post_image_description') is-invalid @enderror" required>{{ $item->post_image_description }}</textarea>
                                    @error('post_image_description')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card card-header-actions mb-4">
                            <div class="card-header">
                                Jadwalkan Post
                            </div>
                            <div class="card-body">
                                <div class="mt-1">
                                    <label for="post-image">Tanggal Post</label>
                                    <input type="datetime-local" name="published_at" value="{{ $item->published_at }}" id="published_at" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card card-header-actions">
                            <div class="card-header">
                                Publish
                                <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="Setelah mengirimkan, posting Anda akan ditinjau untuk dipublikasikan."></i>
                            </div>
                            <div class="card-body">
                                <div class="d-grid">
                                    <div class="d-grid mb-3">
                                        <input type="submit" name="draft" value="Simpan Sebagai Draft" class="fw-500 btn btn-primary-soft text-primary">
                                    </div>
                                    @if (Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor')
                                        <div class="d-grid">
                                            <input type="submit" name="publish" value="Simpan untuk Publikasi" class="fw-500 btn btn-primary">   
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('addon-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <script src="https://cdn.tiny.cloud/1/ogh1hjs7mjdvv73x1cnv3g22gffopydlcw3143b5w576vk93/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endpush

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function checkSchedule(){
            let is_schedule = document.getElementById("is_schedule").value;

            if(is_schedule == 'Ya'){
                document.getElementById('show_schedule').style.display = 'block';
            }else{
                document.getElementById('show_schedule').style.display = 'none';
            }
        }

        $(document).ready(function() {
            $('#category').on('change',function(e) {
                
                var cat_id = e.target.value;

                $.ajax({
                    
                    url:"{{ route('get-sub-categories') }}",
                    type:"POST",
                    data: {
                        cat_id: cat_id
                    },
                    
                    success:function (data) {

                        $('#subcategory').empty();

                        //$('#subcategory').append('<option value="">Pilih</option>');

                        $.each(data.subcategories[0].subcategory,function(index,subcategory){
                            
                            $('#subcategory').append('<option value="'+subcategory.id+'">'+subcategory.name+'</option>');
                        })
                    }
                })
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview-img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); 
            }
        }

        $("#post-image").change(function() {
            readURL(this);
        });

        $(".tag-multiple").select2({
            theme: "bootstrap-5",
            maximumSelectionLength: 4
        });

        $(".cat").select2({
            theme: "bootstrap-5"
        });

        tinymce.init({
            selector: 'textarea#full-featured',
            deprecation_warnings: false,
            plugins: 'print preview paste searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table custom help',
            toolbar1: 'undo redo | bold italic underline | formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | fullscreen  preview | link',
            toolbar2: 'custom_dialog',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            link_list: [
                { title: 'My page 1', value: 'https://www.tiny.cloud' },
                { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_list: [
                { title: 'My page 1', value: 'https://www.tiny.cloud' },
                { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Some class', value: 'class-name' }
            ],
            importcss_append: true,
            file_picker_callback: function (callback, value, meta) {
                /* Provide file and text for the link dialog */
                if (meta.filetype === 'file') {
                    callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
                }

                /* Provide image and alt text for the image dialog */
                if (meta.filetype === 'image') {
                    callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
                }

                /* Provide alternative source and posted for the media dialog */
                if (meta.filetype === 'media') {
                    callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
                }
            },
            templates: [
                { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
                { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
                { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
            ],
            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            height: 950,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image imagetools table',
            skin: 'oxide',
            content_css: 'default',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
@endpush
