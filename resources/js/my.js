jQuery(document).ready(function () {
    // форма добавить
    const link = '[data-fancybox="modal"], .link-modal-js';
    Fancybox.bind(link, {
        arrows: false,
        // infobar: false,
        touch: false,
        trapFocus: false,
        placeFocusBack: false,
        infinite: false,
        dragToClose: false,
        type: 'inline',
        autoFocus: false,
        groupAll: false,
        groupAttr: false,
        l10n: {
            Escape: "Закрыть",
            NEXT: "Вперед",
            PREV: "Назад",
        },
    });

    if ($('#holiday_id').length) {
        $('#holiday_id').select2({
            placeholder: 'Виберіть свято',
            allowClear: true
        });
    }
    $('.nav-form').click(function (e) {
        let href = $(this).attr('href');
        switch (href) {

            case '#ex1-tabs-1':
                $('#holiday_id').attr("required", true);
                $('#welcome').attr("required", true);
                $('#welcome_block').removeClass('d-none');

                $('#photo_block').removeClass('d-none');
                $('#customFile').attr("required", false);

                $('#typeWelcome').val('posts');

                break;

            case '#ex1-tabs-2':
                $('#holiday_id').attr("required", false);
                $('#welcome').attr("required", true);
                $('#welcome_block').removeClass('d-none');

                $('#photo_block').addClass('d-none');
                $('#customFile').attr("required", false);
                $('#typeWelcome').val('anecdotes');

                break;

            case '#ex1-tabs-3':

                $('#holiday_id').attr("required", false);
                $('#welcome').attr("required", false);

                $('#welcome_block').addClass('d-none');

                $('#photo_block').removeClass('d-none');
                $('#customFile').attr("required", true);
                $('#typeWelcome').val('words');

                break;

            default:
                break;
        }

    });
    $('#addWelcome').submit(function (e) {
        e.preventDefault();
        const form = document.getElementById("addWelcome");
        const formData = new FormData(form);
        $('[type="submit"]', $('#addWelcome')).prop('disabled', true);
        axios
            .post("/addWelcome", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            })
            .then((res) => {
                document.getElementById("addWelcome").reset();
            })
            .catch((err) => {
                console.log(err);
            }).then(() => {
                $('[type="submit"]', $('#addWelcome')).prop('disabled', false);
                $('#sucWel').removeClass('d-none');
                setTimeout(() => {
                    $('#sucWel').addClass('d-none');
                    $('.is-close').trigger('click');
                }, 5000);
            });
    });
    // сортировка
    $('#sortSelect').change(function (e) {
        document.getElementById('sortForm').submit();
    });
    // форма подписаться addSubscription
    $('#addSubscription').submit(function (e) {
        e.preventDefault();
        $('#butSubscription').prop('disabled', true);
        axios.post('/subscription', {
                email: $('#email_subscription').val()
            })
            .then(res => {
                document.getElementById("addSubscription").reset();
            })
            .catch(err => {
                console.error(err);
            })
            .then(() => {
                $('#butSubscription').prop('disabled', false);
                $('#sucSub').removeClass('d-none');
                $('#wrapSubscription').addClass('d-none');
                setTimeout(() => {
                    $('.is-close').trigger('click');
                    // $('#sucSub').addClass('d-none');
                }, 5000);

            })
    });
});
