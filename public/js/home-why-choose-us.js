$(function(){
  $("#submitButton").on("click", function(e){
    e.preventDefault();
    console.log('ok');
        formValid = true;
        var title = $('#title').val();
        var sub_title = $('#sub_title').val();
        var image_attribute = $('#image_attribute').val();
        var icon_1 = $('#icon_1').val();
        var icon_title_1 = $('#icon_title_1').val();
        var icon_desc_1 = $('#icon_desc_1').val();
        var icon_2 = $('#icon_2').val();
        var icon_title_2 = $('#icon_title_2').val();
        var icon_desc_2 = $('#icon_desc_2').val();
        var icon_3 = $('#icon_3').val();
        var icon_title_3 = $('#icon_title_3').val();
        var icon_desc_3 = $('#icon_desc_3').val();
        
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




        if (icon_title_1 === '') {
          $('#icon_title_1').css('border-color','red');
           formValid = false;
        }else{
          $('#icon_title_1').css('border-color','#dbdade');
        }
        if (icon_desc_1 === '') {
          $('#icon_desc_1').css('border-color','red');
           formValid = false;
        }else{
          $('#icon_desc_1').css('border-color','#dbdade');
        }
  
        if (icon_title_2 === '') {
          $('#icon_title_2').css('border-color','red');
           formValid = false;
        }else{
          $('#icon_title_2').css('border-color','#dbdade');
        }
        if (icon_desc_2 === '') {
          $('#icon_desc_2').css('border-color','red');
           formValid = false;
        }else{
          $('#icon_desc_2').css('border-color','#dbdade');
        }
     
  
        if (icon_title_3 === '') {
          $('#icon_title_3').css('border-color','red');
           formValid = false;
        }else{
          $('#icon_title_3').css('border-color','#dbdade');
        }
        if (icon_desc_3 === '') {
          $('#icon_desc_3').css('border-color','red');
           formValid = false;
        }else{
          $('#icon_desc_3').css('border-color','#dbdade');
        }



        if (!formValid) {
          return false;
      }
        $('#formValidationWhy').submit();
  });
});