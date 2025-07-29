$(function(){
  const fullEditor1 = new Quill('#full-editor-1', {
    bounds: '#full-editor-1',
    placeholder: 'Type Something...',
    modules: {
      formula: true
    },
    theme: 'snow'
  });

  var description_1_old = $('#working_hours').val();
  $('#full-editor-1 .ql-editor').html(description_1_old);

  $("#submitButton").on("click", function (e) {
    e.preventDefault();
    console.log('ok');
    formValid = true;
    var brand_name = $('#brand_name').val();
    var email_recipient = $('#email_recipient').val();
    var alternate_email = $('#alternate_email').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var landline = $('#landline').val();
    var whatsapp_number = $('#whatsapp_number').val();
    var logo_attribute = $('#logo_attribute').val();
    var footer_logo_attribute = $('#footer_logo_attribute').val();

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var alternateRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phoneRegex = /^\+[0-9]{8,13}$/;
    var whatsappRegex = /^\+[0-9]{8,13}$/;

    if (logo_attribute === '') {
      $('#logo_attribute').css('border-color', 'red');
      formValid = false;
    } else {
      $('#logo_attribute').css('border-color', '#dbdade');
    }
    if (footer_logo_attribute === '') {
      $('#footer_logo_attribute').css('border-color', 'red');
      formValid = false;
    } else {
      $('#footer_logo_attribute').css('border-color', '#dbdade');
    }
    if (brand_name === '') {
      $('#brand_name').css('border-color', 'red');
      formValid = false;
    } else {
      $('#brand_name').css('border-color', '#dbdade');
    }

    if (email_recipient === '') {
      $('#email_recipient').css('border-color', 'red');
      $('#email_recipient_error').text('Email address required.');
      formValid = false;
    } else {

      if (!emailRegex.test(email_recipient)) {
        $('#email_recipient').css('border-color', 'red');
        $('#email_recipient_error').text('Please enter a valid email address.');
        formValid = false;
      } else {
        $('#email_recipient').css('border-color', '#dbdade');
        $('#email_recipient_error').text('');
      }
    }

    if (email === '') {
      $('#email').css('border-color', 'red');
      $('#email_error').text('Email address required.');
      formValid = false;
    } else {
      if (!emailRegex.test(email)) {
        $('#email').css('border-color', 'red');
        $('#email_error').text('Please enter a valid email address.');
        formValid = false;
      } else {
        $('#email').css('border-color', '#dbdade');
        $('#email_error').text('');
      }
    }
    
    if (alternate_email === '') {
      // $('#alternate_email').css('border-color', 'red');
      // $('#alternate_email_error').text('Email address required.');
      // formValid = false;
    } else {
      if (!alternateRegex.test(alternate_email)) {
        $('#alternate_email').css('border-color', 'red');
        $('#alternate_email_error').text('Please enter a valid email address.');
        formValid = false;
      } else {
        $('#alternate_email').css('border-color', '#dbdade');
        $('#alternate_email_error').text('');
      }
    }


    if (phone === '') {
      $('#phone').css('border-color', 'red');
      $('#phone_error').text('Phone Number is required.');
      formValid = false;
    } else {
      if (!phoneRegex.test(phone)) {
        $('#phone').css('border-color', 'red');
        $('#phone_error').text('Please enter a valid phone number with country code.');
        formValid = false;
      } else {
        $('#phone').css('border-color', '#dbdade');
        $('#phone_error').text('');
      }
    }

    if (landline === '') {
      // $('#landline').css('border-color', 'red');
      // $('#landline_error').text('Phone Number is required.');
      // formValid = false;
      $('#landline').css('border-color', '#dbdade');
        $('#landline_error').text('');
    } else {
      if (!phoneRegex.test(landline)) {
        $('#landline').css('border-color', 'red');
        $('#landline_error').text('Please enter a valid phone number with country code.');
        formValid = false;
      } else {
        $('#landline').css('border-color', '#dbdade');
        $('#landline_error').text('');
      }
    }
    if (whatsapp_number === '') {
      $('#whatsapp_number').css('border-color', 'red');
      $('#whatsapp_number_error').text('whatsapp Number is required.');
      formValid = false;
    } else {
      if (!whatsappRegex.test(whatsapp_number)) {
        $('#whatsapp_number').css('border-color', 'red');
        $('#whatsapp_number_error').text('Please enter a valid phone number with country code.');
        formValid = false;
      } else {
        $('#whatsapp_number').css('border-color', '#dbdade');
        $('#whatsapp_number_error').text('');
      }
    }
    
  var description = $('#full-editor-1 .ql-editor').html();
  $('#working_hours').val(description);
    if (!formValid) {
      return false;
    }
    $('#formValidationSiteSetting').submit();
  });
});