<div class="modal fade" style="z-index: 1100000" id="add-value-to-attribute" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">@lang('home.add') @lang('home.options') @lang('home.for')
                    {{ $attribute->{'name_' . $lang} }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap" id="append-vals">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('home.close')</button>
                <button type="button" id="addVal" class="btn btn-primary">@lang('home.save')</button>
            </div>
        </div>
    </div>
</div>
