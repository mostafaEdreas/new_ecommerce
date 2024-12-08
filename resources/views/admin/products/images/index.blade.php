@extends('layouts.admin')
@section('meta')
    <title>{{ trans('home.images') }}</title>
    <style>
        /* Parent container for images */
        .image-preview-container {
            width: 100%;
            height: 200px;
            border: 1px solid #ddd;
            overflow-x: auto;
            display: flex;
            padding: 10px;
            gap: 10px;
        }

        /* Individual image container */
        .image-container {
            width: 100px;
            height: 80px;
            background-color: #000000;
            position: relative;
        }

        /* Image styles */
        .image-container img {
            width: 100%;
            display: block;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Delete button styles */
        .delete-btn {
            position: absolute;
            width: 100% ;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f44336;
            color: #fff;
            border: none;
            font-size: 12px;
            padding: 3px 5px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="spainer"></div>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">{{ trans('home.images') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{ trans('home.admin') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/products') }}">{{ trans('home.products') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/products/' . $parent->id.'/edit') }}">{{ $parent->name }}</a>

                    <li class="breadcrumb-item active" aria-current="page">{{ trans('home.images') }}</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                       <form action="{{$upload_url}}" class="col-12 row" method="post"  name="images[]" multiple  enctype="multipart/form-data">
                        @csrf


                            <div class="mb-3">
                                <label for="image-upload" class="form-label">{{__("home.images")}}</label>
                                <input class="form-control" type="file" id="image-upload" name="images[]" multiple accept="image/jpeg,image/jpg,image/png,image/webp">
                              </div>

                            <div class="image-preview-container" id="image-preview-container">

                            </div>
                            <button type="submit" class="btn btn-primary">{{__('home.upload')}}</button>
                       </form>
                        @if ($parent->images)
                            <div class="col-md-12">
                                <div id="" class="row mb-0">
                                    @foreach ($parent->images as $key => $image)
                                        <div class="col-xs-6 col-sm-2 col-md-2 col-xl-2 mb-2 pl-sm-2 pr-sm-2">
                                            <a href="javascript:void(0)">
                                                <img class="img-responsive" src="{{ $image->image_200 }}"  width="150px" height="150px">
                                            </a>
                                            <div>
                                                <br>
                                                <form class="del-image" id="imag{{$key}}" method="post" action="{{$remove_url}}">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{$image->id}}">
                                                </form>
                                                <a href='javascript:void(0)' onclick="deleteImage('imag{{$key}}')" class='delete_img_btn btn btn-danger'>{{ trans('home.delete') }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const imageUpload = document.getElementById('image-upload');
        const previewContainer = document.getElementById('image-preview-container');

        function deleteImage(form_id){
            console.log(form_id);


            let form = document.getElementById(form_id);
            if (! confirm( '{{ __("home.delete ?") }}' ) || !form.querySelector('input[name="id"]')) {
                e.preventDefault();
            }

            form.submit();
        }

        // Array to track selected files
        let selectedFiles = [];

        // Handle image selection
        imageUpload.addEventListener('change', (event) => {
            const files = Array.from(event.target.files);

            // Add new files to the selectedFiles array
            selectedFiles = [...selectedFiles, ...files];
            renderPreviews();
        });

        // Function to render image previews
        function renderPreviews() {
            previewContainer.innerHTML = ''; // Clear previous previews

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = (e) => {
                    // Create image container
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('image-container');

                    // Create image element
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = `Image ${index + 1}`;

                    // Create delete button
                    const deleteBtn = document.createElement('button');
                    deleteBtn.classList.add('delete-btn');
                    deleteBtn.textContent = 'Delete';

                    // Handle image deletion
                    deleteBtn.addEventListener('click', () => {
                        // Remove file from the selectedFiles array
                        selectedFiles.splice(index, 1);
                        renderPreviews(); // Re-render previews
                        updateFileInput(); // Update the file input
                    });

                    // Append elements to the container
                    imageContainer.appendChild(img);
                    imageContainer.appendChild(deleteBtn);
                    previewContainer.appendChild(imageContainer);
                };

                reader.readAsDataURL(file);
            });
        }

        // Function to update the file input with the current selected files
        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach((file) => dt.items.add(file));
            imageUpload.files = dt.files;
        }


    </script>



@endsection
