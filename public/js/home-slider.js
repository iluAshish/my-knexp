$(function(){
  $("#addButton").on("click", function(e){
    e.preventDefault();
        formValid = true;
        var title = $('#title').val();
        var sub_title = $('#sub_title').val();
        var image = $('#image').val();
        var image_attribute = $('#image_attribute').val();
        
        if (title === '') {
          $('#title').css('border-color','red');
           formValid = false;
        }else{
          $('#title').css('border-color','#dbdade');
        }
        if (sub_title === '') {
          $('#sub_title').css('border-color','red');
           formValid = false;
        }else{
          $('#sub_title').css('border-color','#dbdade');
        }
        if (image === '') {
          $('#image').css('border-color','red');
           formValid = false;
        }else{
          $('#image').css('border-color','#dbdade');
        }
        if (image_attribute === '') {
          $('#image_attribute').css('border-color','red');
           formValid = false;
        }else{
          $('#image_attribute').css('border-color','#dbdade');
        }
        if (!formValid) {
          return false;
      }
        $('#formValidationSliderCreate').submit();
  });

  $("#editButton").on("click", function(e){
    e.preventDefault();
    console.log('ok');
        formValid = true;
        var title = $('#title').val();
        var sub_title = $('#sub_title').val();
        var image_attribute = $('#image_attribute').val();
        
        if (title === '') {
          $('#title').css('border-color','red');
           formValid = false;
        }else{
          $('#title').css('border-color','#dbdade');
        }
        if (sub_title === '') {
          $('#sub_title').css('border-color','red');
           formValid = false;
        }else{
          $('#sub_title').css('border-color','#dbdade');
        }
        if (image_attribute === '') {
          $('#image_attribute').css('border-color','red');
           formValid = false;
        }else{
          $('#image_attribute').css('border-color','#dbdade');
        }
        if (!formValid) {
          return false;
      }
        $('#formValidationSliderEdit').submit();
  });
});