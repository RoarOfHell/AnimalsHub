const checkBox = document.getElementById('agreeCheck');

checkBox.addEventListener('change', function () {
    if (this.checked) {
        var modal = new bootstrap.Modal(document.getElementById('modalAgreement'));
        modal.show();
    }
});