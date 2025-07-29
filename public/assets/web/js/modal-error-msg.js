$('#modal_fname').on('input', function() {
  var inputValue = $(this).val();
  var alphabeticOnly = inputValue.replace(/[^a-zA-Z\s]/g, ''); // Remove non-alphabetic characters
  $(this).val(alphabeticOnly);
});
document.getElementById('modal-form').addEventListener('submit', function(event) {
              // Prevent the default form submission behavior
              event.preventDefault();

              // Check each input field for errors
              const nameInput = document.getElementById('modal_fname');
              const emailInput = document.getElementById('modal_email');
              const numberInput = document.getElementById('modal_number');
              const service = document.getElementById('modal_service');
              const message = document.getElementById('modal_msg');
              let formValid = true;


              var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
              var phoneRegex = /^[+]?[0-9\s]{8,15}$/;


              if (nameInput.value.trim() === '') {
                document.getElementById('modal_error-name').style.display = 'block';
                formValid = false;
              } else {
                document.getElementById('modal_error-name').style.display = 'none';
              }

            if (emailInput.value.trim() === '') {
                document.getElementById('modal_error-email').style.display = 'block';
                $('#modal_error-email').text('Email address required.');
                formValid = false;
              } else {
                if (!emailRegex.test(emailInput.value)) {
                  document.getElementById('modal_error-email').style.display = 'block';
                  $('#modal_error-email').text('Please enter a valid email address.');
                  formValid = false;
                } else {
                  $('#modal_error-email').hide();
                }
              }
              if (numberInput.value.trim() === '') {
                document.getElementById('modal_error-number').style.display = 'block';
                $('#modal_error-number').text('Phone Number is required.');
                formValid = false;
              } else {
                if (!phoneRegex.test(numberInput.value)) {
                  document.getElementById('modal_error-number').style.display = 'block';
                  $('#modal_error-number').text('Please enter a valid Phone Number.');
                  formValid = false;
                } else {
                  $('#modal_error-number').hide();
                }
              }


              if (service.value.trim() === '') {
                document.getElementById('modal_error-service').style.display = 'block';
                formValid = false;
              } else {
                document.getElementById('modal_error-service').style.display = 'none';
              }

              // If there are errors, do not proceed with the form submission
              if (!formValid) {
                return false;
              }

              // If all fields are filled, proceed with form submission
              // You can use AJAX or other methods here to submit the form data to the server
              // For this example, we will just submit the form normally
              this.submit();
            });
