$(function(){
  const fullEditor1 = new Quill('#full-editor-1', {
    bounds: '#full-editor-1',
    placeholder: 'Type Something...',
    modules: {
      formula: true
    },
    theme: 'snow'
  });

  const fullEditor2 = new Quill('#full-editor-2', {
    bounds: '#full-editor-2',
    placeholder: 'Type Something...',
    modules: {
      formula: true
    },
    theme: 'snow'
  });

  var description_1_old = $('#description').val();
  $('#full-editor-1 .ql-editor').html(description_1_old);

  var description_2_old = $('#description_2').val();
  $('#full-editor-2 .ql-editor').html(description_2_old);
  $("#submitButton").on("click", function(e){
    e.preventDefault();
    console.log('ok');
        formValid = true;
        var title = $('#title').val();
        var sub_title = $('#sub_title').val();
        var image_attribute = $('#image_attribute').val();
        var description = $('#description').val();
        var title_2 = $('#title_2').val();
        var description_2 = $('#description_2').val();


        var descr1 = $('#full-editor-1 .ql-editor').html();
        $('#description').val(descr1);

        var descr2 = $('#full-editor-2 .ql-editor').html();
        $('#description_2').val(descr2);

        
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
        if (description === '<p><br></p>') {
          $('#description').css('border-color','red');
           formValid = false;
        }else{
          $('#description').css('border-color','#dbdade');
        }
        if (title_2 === '') {
          $('#title_2').css('border-color','red');
           formValid = false;
        }else{
          $('#title_2').css('border-color','#dbdade');
        }
        if (description_2 === '<p><br></p>') {
          $('#description_2').css('border-color','red');
           formValid = false;
        }else{
          $('#description_2').css('border-color','#dbdade');
        }
        if (!formValid) {
          return false;
      }
        $('#formValidationabout').submit();
  });
});