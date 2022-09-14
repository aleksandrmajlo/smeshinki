<div id="formsend" style="display:none;max-width:800px;width: 100%;">
    <div class="container-fluid">
        <form method="POST" id="addWelcome">
            @csrf
            <h2 class="text-center mb-5">Додати</h2>
            <!-- Tabs navs -->
            <ul class="nav nav-fill nav-tabs mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link
                        nav-form
                        active"
                        id="ex1-tab-1"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-1"
                        role="tab"
                        aria-controls="ex1-tabs-1"
                        aria-selected="true"
                    >Привітання</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link nav-form"
                        id="ex1-tab-2"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-2"
                        role="tab"
                        aria-controls="ex1-tabs-2"
                        aria-selected="false"
                    >Анекдот</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link nav-form"
                        id="ex1-tab-3"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-3"
                        role="tab"
                        aria-controls="ex1-tabs-3"
                        aria-selected="false"
                    >Світлину</a
                    >
                </li>
            </ul>
            <!-- Tabs navs -->
            {{--            <div class="row mb-3">--}}
            {{--                <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('auth.Name') }}</label>--}}
            {{--                <div class="col-md-10">--}}
            {{--                    <input id="name" type="text" class="form-control " name="name" value="" required autocomplete="name" autofocus>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="row mb-3">--}}
            {{--                <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('Email ') }}</label>--}}
            {{--                <div class="col-md-10">--}}
            {{--                    <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">--}}
            {{--                </div>--}}
            {{--            </div>--}}


            <div class="row mb-3">
                <label for="title" class="col-md-2 col-form-label text-md-end">Заголовок</label>
                <div class="col-md-10">
                    <input class="form-control" name="title" required id="title">
                </div>
            </div>
            <div class="row mb-3" id="welcome_block">
                <label for="welcome" class="col-md-2 col-form-label text-md-end">Текст</label>
                <div class="col-md-10">
                    <textarea name="welcome"
                              id="welcome"
                              class="form-control " required></textarea>
                </div>
            </div>
            <div class="row mb-3" id="photo_block">
                <label for="customFile" class="col-md-2 col-form-label text-md-end">Світлина</label>
                <div class="col-md-10">
                    <input type="file" name="photo" accept="image/png, image/jpeg"
                           class="form-control" id="customFile"/>
                </div>
            </div>
            <!-- Tabs content -->
            <div class="tab-content" id="ex1-content">
                <div
                    class="tab-pane fade show active"
                    id="ex1-tabs-1"
                    role="tabpanel"
                    aria-labelledby="ex1-tab-1"
                >

                    <div class="row mb-3" id="holiday_block">
                        <label class="col-md-2 col-form-label text-md-end">Свято</label>
                        <div class="col-md-10">
                            <select class="form-control"
                                    style="width: 100%;"
                                    name="holiday_id"
                                    required
                                    data-placeholder="Виберіть свято"
                                    id="holiday_id">
                                @foreach($holidaysForm  as $item)
                                    <option value="{{$item->id}}">{{$item->title}} - {{$item->date}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <button  type="submit"  class="btn btn-primary">Відправити привітання</button>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <button  type="submit"  class="btn btn-primary">Відправити анекдот</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <button  type="submit"  class="btn btn-primary">Відправити світлину</button>
                        </div>
                    </div>
                </div>

            </div>
            <input type="hidden" name="type" id="typeWelcome" value="posts">
            <!-- Tabs content -->
            <div class="row mb-3 d-none" id="sucWel">
                <div class="col-md-12 text-center text-success">
                    Ваше контент отримано!
                </div>
            </div>

        </form>
    </div>
</div>
