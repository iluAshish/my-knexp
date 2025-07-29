$(function(){
    $("#submitButton").on("click", function(e){
      e.preventDefault();
          formValid = true;
          var first_name = $('#first_name').val();
          var last_name = $('#last_name').val();
          var email = $('#email').val();
          var phone = $('#phone').val();
          var address = $('#address').val();

          if (first_name === '') {
            $('#first_name').css('border-color','red');
             formValid = false;
          }else{
            $('#first_name').css('border-color','#dbdade');
          }

        if (last_name === '') {
            $('#last_name').css('border-color','red');
            formValid = false;
        }else{
            $('#last_name').css('border-color','#dbdade');
        }

          if (email === '') {
            $('#email').css('border-color','red');
             formValid = false;
          }else{
            $('#email').css('border-color','#dbdade');
          }
          if (phone === '') {
            $('#phone').css('border-color','red');
             formValid = false;
          }else{
            $('#phone').css('border-color','#dbdade');
          }
          if (address === '') {
            $('#address').css('border-color','red');
             formValid = false;
          }else{
            $('#address').css('border-color','#dbdade');
          }
          if (!formValid) {
            return false;
        }
          $('#addNewCustomerForm').submit();
    });
  });
