jQuery(document).ready(function () {
    // форма добавить
    $('#addWelcome').submit(function (e) {
        e.preventDefault();
        const form = document.getElementById("addWelcome");
        const formData = new FormData(form);
        $('#butWelcome').prop('disabled', true);
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
                $('#butWelcome').prop('disabled', false);
                $('#sucWel').removeClass('d-none');
                setTimeout(() => {
                    $('#sucWel').addClass('d-none');
                }, 4000);
            });
    });
    // сортировка
    $('#sortSelect').change(function (e) {
        document.getElementById('sortForm').submit();
    });
});
