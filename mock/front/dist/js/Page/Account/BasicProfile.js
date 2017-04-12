$(function() {
    var $licenseAgreementCheckBox = $('#chk-license-agreement');

    if ($licenseAgreementCheckBox.size()) {
        var $submitButton = $licenseAgreementCheckBox.closest('div.form-group').next('p').find('button');

        $licenseAgreementCheckBox.click(function () {
            if (this.checked) {
                $submitButton.removeClass('disabled');
            } else {
                $submitButton.addClass('disabled');
            };
        });
        $licenseAgreementCheckBox.triggerHandler('click');
    };
});