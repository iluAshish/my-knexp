$(function(){
  $("#addButton").on("click", function(e){
    e.preventDefault();
    console.log('ok');
        formValid = true;
        var title = $('#title').val();
        var description = $('#description').val();
        var image = $('#image').val();
        var image_attribute = $('#image_attribute').val();
        var icon = $('#icon').val();
        var icon_attribute = $('#icon_attribute').val();
        
        if (title === '') {
          $('#title').css('border-color','red');
           formValid = false;
        }else{
          $('#title').css('border-color','#dbdade');
        }
        if (description === '') {
          $('#description').css('border-color','red');
           formValid = false;
        }else{
          $('#description').css('border-color','#dbdade');
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
        
        if (icon === '') {
          $('#icon').css('border-color','red');
           formValid = false;
        }else{
          $('#icon').css('border-color','#dbdade');
        }
        if (icon_attribute === '') {
          $('#icon_attribute').css('border-color','red');
           formValid = false;
        }else{
          $('#icon_attribute').css('border-color','#dbdade');
        }
        if (!formValid) {
          return false;
      }
        $('#formValidationServiceCreate').submit();
  });

  $("#submitButton").on("click", function(e){
    e.preventDefault();
    console.log('ok');
        formValid = true;
        var title = $('#title').val();
        var description = $('#description').val();
        var image_attribute = $('#image_attribute').val();
        var icon_attribute = $('#icon_attribute').val();
        
        if (title === '') {
          $('#title').css('border-color','red');
           formValid = false;
        }else{
          $('#title').css('border-color','#dbdade');
        }
        if (description === '') {
          $('#description').css('border-color','red');
           formValid = false;
        }else{
          $('#description').css('border-color','#dbdade');
        }

        if (image_attribute === '') {
          $('#image_attribute').css('border-color','red');
           formValid = false;
        }else{
          $('#image_attribute').css('border-color','#dbdade');
        }
        
  
        if (icon_attribute === '') {
          $('#icon_attribute').css('border-color','red');
           formValid = false;
        }else{
          $('#icon_attribute').css('border-color','#dbdade');
        }
        if (!formValid) {
          return false;
      }
        $('#formValidationService').submit();
  });
});