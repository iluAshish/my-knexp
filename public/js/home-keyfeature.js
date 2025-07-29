$(function(){
  $("#addButton").on("click", function(e){
    e.preventDefault();
    console.log('ok');
        formValid = true;
        var title = $('#title').val();
        var number = $('#number').val();
        var image = $('#image').val();
        var image_attribute = $('#image_attribute').val();
        
        if (title === '') {
          $('#title').css('border-color','red');
           formValid = false;
        }else{
          $('#title').css('border-color','#dbdade');
        }
        if (number === '') {
          $('#number').css('border-color','red');
           formValid = false;
        }else{
          $('#number').css('border-color','#dbdade');
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
        $('#formValidationkeyfeatureCreate').submit();
  });
  
  $("#editButton").on("click", function(e){
    e.preventDefault();
    console.log('ok');
        formValid = true;
        var title = $('#title').val();
        var number = $('#number').val();
        var image_attribute = $('#image_attribute').val();
        
        if (title === '') {
          $('#title').css('border-color','red');
           formValid = false;
        }else{
          $('#title').css('border-color','#dbdade');
        }
        if (number === '') {
          $('#number').css('border-color','red');
           formValid = false;
        }else{
          $('#number').css('border-color','#dbdade');
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
        $('#formValidationkeyfeatureEdit').submit();
  });
});