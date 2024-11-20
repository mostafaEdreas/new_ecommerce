
<style>
    .image-preview{
        border: 1px solid black;
        height: 300px;
        overflow: auto;
    }

</style>
<div class="card p-3 mb-3">
    <div class="row">
        <div class="form-group col-md-6">
            <label>{{trans('home.image')}}</label>
            <div class="input-group ">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{trans('home.upload')}}</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="images[]" id="fileInputs" multiple>
                    <label class="custom-file-label" for="inputGroupFile01">{{trans('home.choose_image')}}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="image-preview d-flex flex-wrap  p-2 mb-5"  id="image-preview" ></div>
        <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <button onclick="saveAllImages()" class="btn btn-success"><i class="icon-note"></i> {{trans('home.save')}} @lang('home.all') </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
    <div class="image-preview d-flex flex-wrap  p-2" id="image-uploaded">
        @foreach($showImages as $image)
            <div class='d-flex flex-column m-2' style="width:100px; height:max-content;">
                <button class="badge badge-danger delete-image" onclick='removePdfFromDB("{{$image->id}}",this)' >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg>
                </button>
                <img src='{{url("uploads/$folder/source/$image->image")}}' >
            </div>
        @endforeach
    </div>

    <!-- End Row -->

    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <button  class="btn btn-danger" onclick="deleteAllImages()"  ><i class="icon-note"></i> {{trans('home.delete')}} @lang('home.all') </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
</div>
