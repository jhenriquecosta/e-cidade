$(function() {

  var $oForm        = $('#formNotaEmail');
  var $oEnviarEmail = $('#enviar_email');
  var $oMessage     = $('.ajax-message');
  var $oTarget      = $('#email_erros');
  
  // Lanca Servico
  $oEnviarEmail.click(function(e) {
    var $oThis    = $(this);
    var txtElm    = $(this).html();
    
    // Remove as mensagens de erro
    $oMessage.remove();
    
    $.ajax({
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      beforeSend  : function() { $oThis.html('Aguarde...').attr('disabled', true); },
      complete    : function() { $oThis.html(txtElm).attr('disabled', false); },
      error       : function(xhr, err) {
        
        $oThis.attr('disabled', false);
        
        if (xhr.responseText) {
          
          var error = $.parseJSON($.trim(xhr.responseText));
          
          bootbox.alert(error.exception.information);
          
          if (error.exception) {
            console.log(error.exception);
          }
        } else {
          bootbox.alert('Ocorreu um erro ao processar!<br>readyState: ' +xhr.readyState+ '<br>status: ' +xhr.status);
        }
      },
      success     : function(data) {
         
        $oForm.find('.error').removeClass('error'); // Remove as classes de erro
         
        if (data && data.status && data.success) {
            
          var sMessage = '<div class="alert alert-success ajax-message"> '+
                          '  <button type="button" class="close" data-dismiss="alert">×</button>' +data.success+ 
                          '</div>';
          
          $oTarget.html(sMessage);
        } else if (data && data.error) {
          
          var errors = '';
          
          $.each(data.error, function(i) {
            errors = errors + data.error[i]+ '\n';  
          });
          
          if (data.fields != undefined) {
            $.each(data.fields, function(i) {
              $('#' +data.fields[i]).prev('label').addClass('error');
              $('#' +data.fields[i]).addClass('error').focus();
            });
          }
          
          var sMessage = '<div class="alert alert-error ajax-message"> '+
                         '  <button type="button" class="close" data-dismiss="alert">×</button>' +errors+ 
                         '</div>';
          
          $oTarget.html(sMessage);
          
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      }
    });
    
    e.preventDefault();
    return false;
  });
});