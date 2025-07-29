$(function(){
    $("#submitButton").on("click", function(e){
      e.preventDefault();
          formValid = true;
          var week_dates = $('#week_dates').val();
          
          if (week_dates === '') {
            $('#week_dates').css('border-color','red');
             formValid = false;
          }else{
            $('#week_dates').css('border-color','#dbdade');
          }

          if (!formValid) {
            return false;
        }
          $('#addNewDateForm').submit();
    });
  });