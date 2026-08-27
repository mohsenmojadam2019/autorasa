<div @class(['modal-dialog'])>
        <div @class(['modal-content border-0'])>
                <div class="d-none d-md-block col-6 campaign-popup-bg"></div>

        <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>

        <div class="campaign-popup-content">
            <div class="modal-header flex-column align-items-start border-0 p-0">
                    <span class="modal-subtitle">
{{--                        {!! BaseHelper::clean($subtitle) !!}--}}
                    </span>
                    <h5 class="modal-title fs-2" id="campaignPopupModalLabel">
{{--                        {!! BaseHelper::clean($title) !!}--}}
                    </h5>
                    <p class="modal-text text-muted">
{{--                        {!! BaseHelper::clean($description) !!}--}}
                    </p>
            </div>
            <div class="modal-body p-0">
{{--                {!! $campaignForm->setFormOption('class', 'bb-campaign-popup-form')->renderForm() !!}--}}
            </div>
        </div>
    </div>
</div>
