$(function(){
    $("#submitButton").on("click", function(e){
      e.preventDefault();
          formValid = true;
          var week_days = $('#week_days').val();
          
          if (week_days === '') {
            $('#week_days').css('border-color','red');
             formValid = false;
          }else{
            $('#week_days').css('border-color','#dbdade');
          }

          if (!formValid) {
            return false;
        }
          $('#addNewDayForm').submit();
    });
  });