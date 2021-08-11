$(function() {
  
  /**
   * Elementos
   */
  var $form         = $('#form1');
  var $btnProcessar = $('#submit');

  /**
   * Controles do Form 
   */
  $btnProcessar.click(function(e) {
    var $eThis = $(this);
    
    $form.ajaxForm({
        type        : 'GET',
        dataType    : 'json',
        url         : $form.attr('action'),
        data        : $form.serialize(),
        crossDomain : true,
        async       : false,
        beforeSubmit: function() { 
          $btnProcessar.attr('disabled', false);
        },
        complete    : function() {
          
          $btnProcessar.attr('disabled', false);
        },
        success     : function(data) {
          
          if (data.status && data.success && data.url) {
            bootbox.alert(data.success, function() { location.href = data.url; });
          } else if (data.error) {
            
            var erros = '';
            
            $.each(data.error, function(i) {
              erros = data.error[i]+ '\n';  
            });
            
            bootbox.alert(erros);  
          } else {
            bootbox.alert('Ocorreu um erro desconhecido!');
          }
        },
        error       : function(xhr, err, thrownError) {
          
          if (xhr.responseText) {
            
            var error = $.parseJSON($.trim(xhr.responseText));
            
            bootbox.alert(error.message);
            
            if (error.exception) {
              console.log(error.exception);
            }
          } else {
            bootbox.alert('Ocorreu um erro desconhecido!<br>readyState: ' +xhr.readyState+ '<br>status: ' +xhr.status);
          }
          
          $eThis.attr('disabled', false);
        }
      });
  });
});