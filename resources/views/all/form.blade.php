<div id="formsend" style="display:none;max-width:800px;width: 100%;">
    <div class="container-fluid">
        <form method="POST" id="addWelcome">
            <h2 class="text-center">Додати своє привітання</h2>
            @guest
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('auth.Name') }}</label>
                    <div class="col-md-10">
                        <input id="name" type="text" class="form-control " name="name" value="" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('Email ') }}</label>
                    <div class="col-md-10">
                        <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">
                    </div>
                </div>
            @else
            @endguest
            <div class="row mb-3">
                <label for="welcome" class="col-md-2 col-form-label text-md-end">Привітання</label>
                <div class="col-md-10">
                    <textarea name="welcome" class="form-control " required></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="welcome" class="col-md-2 col-form-label text-md-end">Картинка</label>
                <div class="col-md-10">
                    <input type="file" name="photo" accept="image/png, image/jpeg" class="form-control" id="customFile" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <button  id="butWelcome" type="submit" class="btn btn-primary">Відправити</button>
                </div>
            </div>
            <div class="row mb-3 d-none" id="sucWel">
                <div class="col-md-12 text-center text-success">
                    Ваше привітання отримано!
                </div>
            </div>
        </form>
    </div>
</div>
