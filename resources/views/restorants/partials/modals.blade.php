<div class="modal fade" id="productModal" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title" id="modal-title-new-item"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="row">
                            <div class="col-sm col-md col-lg col-lg text-center">
                                <img id="modalImg" src="" width="295px" height="200px">
                            </div>
                            <div class="col-sm col-md col-lg col-lg">
                                <input id="modalID" type="hidden"></input>
                                <span id="modalPrice" class="new-price"></span>
                                <p id="modalDescription"></p>
                                <div id="variants-area">
                                    <label class="form-control-label">{{ __('Select your options') }}</label>
                                    <div id="variants-area-inside">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
