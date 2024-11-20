@extends('layouts.app')

    
@section('meta')
    @php echo $metatags @endphp

    @php echo $schema @endphp
@endsection

    
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection

@section('content')


<main class="main">
    <nav class="breadcrumb-nav mb-10">
        <div class="container">
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{trans('home.inspection_request')}}</h1>
                     <ul class="breadcrumb">
                        <li><a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('home.home')}}</a></li>
                        <li>{{trans('home.inspection_request')}}</li>
                    </ul>
                </div>
           </div>
        </div>
    </nav>
    
    <div class="page-content contact-us">
        <div class="container">
            <section class="contact-section">
                <div class="row gutter-lg pb-3">
                    <div class="col-lg-6 mb-8">
                        <h2 class="text-center head-contact">{{ trans('home.inspection_request') }}</h2>
                        <p class="text-center">{{ trans('home.please_fill_out_quick_form_and_we_will_be_in_touch_with_lightening_speed') }} .</p>
                        
                         @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form class="form contact-us-form" action="{{url('save/contact-us')}}" method="post">
                            
                            @csrf	
                            <div class="form-group">
                                <label for="name">{{trans('home.name')}}</label>
                                <input type="text" id="username" name="name" class="form-control" value="{{old('name')}}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">{{trans('home.email')}}</label>
                                <input type="email" id="email_1" name="email" class="form-control" value="{{old('email')}}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">{{trans('home.phone')}}</label>
                                <input type="tel"  pattern="^01[0-2]\d{1,8}$" id="email_1" name="phone" class="form-control" value="{{old('phone')}}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">{{trans('home.address')}}</label>
                                <select class="form-control select2 address" name="address">
                                    <option value="Downtown">{{trans('home.Downtown')}}</option>
                                    <option value="Nasr City">{{trans('home.Nasr City')}}</option>
                                    <option value="Heliopolis">{{trans('home.Heliopolis')}}</option>
                                    <option value="Rehab">{{trans('home.Rehab')}}</option>
                                    <option value="Madinaty">{{trans('home.Madinaty')}}</option>
                                    <option value="Fasel">{{trans('home.Fasel')}}</option>
                                    <option value="Haram">{{trans('home.Haram')}}</option>
                                    <option value="Maadi">{{trans('home.Maadi')}}</option>
                                    <option value="Helwan">{{trans('home.Helwan')}}</option>
                                    <option value="El Sheikh Zayed">{{trans('home.El Sheikh Zayed')}}</option>
                                    <option value="6 October">{{trans('home.6 October')}}</option>
                                    <option value="Alexandria">{{trans('home.Alexandria')}}</option>
                                    <option value="North Cost">{{trans('home.North Cost')}}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">{{trans('home.product_type')}}</label>
                                <select class="form-control select2 category" name="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{(app()->getLocale()=='en')? $category->name_en:$category->name_ar}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">{{trans('home.note')}}</label>
                                <textarea id="message" name="message" cols="30" rows="5" class="form-control" required>{{old('message')}}</textarea>
                            </div>

                            <button type="submit" class="btn btn-dark btn-rounded">{{trans('home.send')}}</button>
                        </form>
                    </div>
                    
                    <div class="col-lg-6 mb-8">
                        <figure class="br-lg">
                            <img src="{{url('uploads/settings/source/'.$configration->inspection_request_image)}}" alt="inspection request image" width="610" height="500"/>
                        </figure>
                    </div>
                </div>
            </section>
            <!-- End of Contact Section -->
        </div>
    </div>
       
</main>
@endsection

@section('script')

    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <script>
        grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
            });
        });
    </script>

    <script>
        $('form#contact_form').submit(function(){
            $(this).find(':input[type=submit]').prop('disabled', true);
        });
        
        $('.address').select2({
            'placeholder':'{{trans("home.address")}}',
             allowClear: true,
        });
        
        $('.category').select2({
            'placeholder':'{{trans("home.category")}}',
             allowClear: true,
        });
        
        
    </script>

    @if(Session::has('contact_message'))
        <script>
            $.alert({
                title: "{{trans('home.contact_us')}}",
                content: "{{Session::get('contact_message')}}",
                buttons: {
                    ok: {
                        text: "{{trans('home.OK')}}",
                        btnClass: 'btn main-btn',
                    },
                },
                columnClass: 'col-md-6'
            });
        </script>
    @endif
    @php
        Session::forget('contact_message')
    @endphp
@endsection    