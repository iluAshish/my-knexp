
  $('#fname').on('input', function() {
    var inputValue = $(this).val();
    var alphabeticOnly = inputValue.replace(/[^a-zA-Z\s]/g, ''); // Remove non-alphabetic characters
    $(this).val(alphabeticOnly);
});
  document.getElementById('enquiry-form').addEventListener('submit', function(event) {
              // Prevent the default form submission behavior
              event.preventDefault();

              // Check each input field for errors
              const nameInput = document.getElementById('fname');
              const emailInput = document.getElementById('email');
              const numberInput = document.getElementById('number');
              const service = document.getElementById('service');
              const message = document.getElementById('msg');
              let formValid = true;

              var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
              var phoneRegex = /^[+]?[0-9\s]{8,15}$/;
              var nameRegex = /^[a-zA-Z]+$/;


              if (nameInput.value.trim() === '') {
                document.getElementById('error-name').style.display = 'block';
                $('#error-name').text('Please enter your full name. ');
                formValid = false;
              } else {

                // if (!nameRegex.test(nameInput.value)) {
                //   document.getElementById('error-name').style.display = 'block';
                //   $('#error-name').text('Please enter Alphabetic Characters');
                //   formValid = false;
                // } else {
                // }
                $('#error-name').hide();
              }

              if (emailInput.value.trim() === '') {
                document.getElementById('error-email').style.display = 'block';
                $('#error-email').text('Email address required.');
                formValid = false;
              } else {
                if (!emailRegex.test(emailInput.value)) {
                  document.getElementById('error-email').style.display = 'block';
                  $('#error-email').text('Please enter a valid email address.');
                  formValid = false;
                } else {
                  $('#error-email').hide();
                }
              }
              if (numberInput.value.trim() === '') {
                document.getElementById('error-number').style.display = 'block';
                $('#error-number').text('Phone Number is required.');
                formValid = false;
              } else {
                if (!phoneRegex.test(numberInput.value)) {
                  document.getElementById('error-number').style.display = 'block';
                  $('#error-number').text('Please enter a valid Phone Number');
                  formValid = false;
                } else {
                  $('#error-number').hide();
                }
              }




              if (service.value.trim() === '') {
                document.getElementById('error-service').style.display = 'block';
                formValid = false;
              } else {
                document.getElementById('error-service').style.display = 'none';
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
