$(function() {
  
  /**
   * Elementos
   */
  var $oBtnProcessar = $('#submit');
  var $oForm         = $oBtnProcessar.closest('form');

  /**
   * Controles do Form 
   */
  $oBtnProcessar.click(function(e) {
    var $eThis = $(this);
    var texto  = $eThis.val();
    
    $oForm.ajaxForm({
      type        : 'post',
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      async       : true,
      beforeSubmit: function() {
        $eThis.attr('disabled', true).val('Aguarde...');
      },
      complete    : function() {
        $eThis.attr('disabled', false).val(texto);
      },
      success     : function(data) {
        
        try {
          
          if (data.status && data.success && data.url) {
            bootbox.alert(data.success, function() { location.href = data.url; });
          } else if (data.status && data.success) {
            bootbox.alert(data.success, function() { location.reload(); });
          } else if (data.error) {
            
            var errors = '';
            
            if ((data.error).length > 1) {
              errors = '<ul>';  
            }
            
            $.each(data.error, function(i) {
              
              if (i > 0) {
                errors = errors + '<li>' + data.error[i] + '</li>';
              } else {
                errors = errors + data.error[i];
              }
            });
            
            if ((data.error).length > 1) {
              errors = errors  + '</ul>';  
            }
            
            if (data.fields != undefined) {
              
              $.each(data.fields, function(i) {
                $('#' +data.fields[i]).closest('.control-group').addClass('error');
              });
            }
            
            var $divAjaxMensagem = $('.ajax-message');
            
            $divAjaxMensagem.remove();
            
            var sMessage = '<div class="alert alert-error ajax-message"> '+
                           '  <button type="button" class="close" data-dismiss="alert">×</button>' +errors+ 
                           '</div>';
            
            $eThis.closest('fieldset').before(sMessage);
          }
        } catch (Exception) {
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
        
        $eThis.attr('disabled', false).val(texto);
      }
    });
  });
});