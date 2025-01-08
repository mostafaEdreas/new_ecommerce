<div class="contact-area1 style-1 m-r20 m-md-r0 wow fadeInUp" data-wow-delay="0.5s">
    <form id="contactSubmit" action="{{LaravelLocalization::localizeUrl('save/contact-us')}}" class="dz-form " method="POST">
        @csrf
        <label class="form-label">@lang('home.name')</label>
        <div class="input-group">
            <input required type="text" class="form-control" name="name">
        </div>
        <label class="form-label">@lang('home.email')</label>
        <div class="input-group">
            <input required type="text" class="form-control" name="email">
        </div>
        <label class="form-label">@lang('home.phone')</label>
        <div class="input-group">
            <input required type="text" class="form-control" name="phone">
        </div>
        <label class="form-label">@lang('home.message')</label>
        <div class="input-group m-b30">
            <textarea name="message" rows="4" required class="form-control m-b10"></textarea>
        </div>
        <div>
            <button name="submit" type="submit" value="submit" class="btn w-100 btn-secondary btnhover">SUBMIT</button>
        </div>
    </form>
</div>