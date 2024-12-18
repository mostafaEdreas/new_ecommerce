<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('home.call_us')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled footer-widget__contact phone">
                    <li>
                        <i class="agrikon-icon-telephone"></i>
                        <a href="tel:+2{{config('site_mobile')}}"><span>@lang('home.phone1') :</span>{{config('site_mobile')}}</a>
                    </li>
                    <li>
                        <i class="agrikon-icon-telephone"></i>
                        <a href="tel:+2{{config('site_telephone')}}"><span>@lang('home.phone2') :</span>{{config('site_telephone')}}</a>
                    </li>
                    <li>
                        <i class="agrikon-icon-telephone"></i>
                        <a href="tel:+2{{config('site_whatsapp')}}"><span>@lang('home.whatsapp') :</span> {{config('site_whatsapp')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>