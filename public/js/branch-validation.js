$(function () {
    $("#submitButton").on("click", function (e) {
        e.preventDefault();

        var formValid = true;

        function validateField(field, errorMessage) {
            if (field.val().trim() === '') {
                field.css('border-color', 'red');
                formValid = false;
            } else {
                field.css('border-color', '#dbdade');
            }
        }

        // Validation for each field
        var state = $('#state_id');
        var select2Container = state.next('.select2-container');

        if (state.val().trim() === '') {
            console.log(state.val())
            formValid = false;
            select2Container.find('.select2-selection').css('border-color', 'red');
        } else {
            select2Container.find('.select2-selection').css('border-color', '#dbdade');
        }

        validateField($('#name'), 'Branch Name is required');
        validateField($('#branch_code'), 'Branch code is required');
        validateField($('#phone'), 'Phone is required');
        validateField($('#address'), 'Address is required');

        if (formValid) {
            $('#addNewCustomerForm').submit();
        }

        return formValid;
    });
});
