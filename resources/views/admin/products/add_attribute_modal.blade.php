<div class="modal fade" style="z-index: 1000000" id="add-attributes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">@lang('home.add') @lang('home.attributes')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow: auto;">
                <div class="accordion row " id="new-attrs">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('home.close')</button>
                <button type="button" id="addAttrVal" class="btn btn-primary">@lang('home.save')</button>
            </div>
        </div>
    </div>
</div>
