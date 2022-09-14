<div id="form_subscription" style="display:none;max-width:800px;width: 100%;">
    <div class="container-fluid">
        <form method="POST" id="addSubscription">
            <h2 class="text-center mb-5">Підписатися на гуморне розсилання</h2>

            <div id="wrapSubscription">
                <div class="row mb-3">
                    <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('Email ') }}</label>
                    <div class="col-md-10">
                        <input id="email_subscription" type="email" class="form-control " name="email" value="" required autocomplete="email">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <button  id="butSubscription" type="submit" class="btn btn-primary">Підписатися</button>
                    </div>
                </div>
            </div>
            <div class="row mb-3 d-none" id="sucSub">
                <div class="col-md-12 text-center text-success">
                    На вказаний email надіслано листа для підтвердження підписки.
                </div>
            </div>
        </form>
    </div>
</div>
