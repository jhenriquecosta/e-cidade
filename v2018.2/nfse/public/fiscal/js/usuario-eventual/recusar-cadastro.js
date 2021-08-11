$(function() {
  var $oForm         = $('#formCadastroPessoaRecusa');
  var $oConfirmar    = $('#confirmar');
  var $oCancelar     = $('#cancelar, .close');
  var $oFormErros    = $('#erros');
  var $oModal        = $('#myModal');
  var $oModalOverlay = $('.modal-backdrop');
  
  // Envio do formulário
  $oConfirmar.click(function(e) {
    
    var textoBotao = $(this).html(); 
    
    $.ajax({
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      beforeSend  : function() {
        
        $oFormErros.html('');
        $oForm.find('.error').removeClass('error');
        $oForm.find('textarea').attr('readonly', true).addClass('readonly');
        $oConfirmar.html('Aguarde...').attr('disabled', true);
        $oCancelar.attr('disabled', true);  
      },
      complete  : function() {
        
        $oForm.find('textarea').attr('readonly', false).addClass('readonly');
        $oConfirmar.html(textoBotao).attr('disabled', false);
        $oCancelar.attr('disabled', false);
      },
      success     : function(data) {
        
        if (data.status) {
          
          $oModal.hide();
          $oModalOverlay.css({ 'opacity': 0 });
          
          bootbox.alert(data.success, function() { location.reload(); });
        } else if (data.error) {
          
          var errors = '';
          
          $.each(data.error, function(i) {
            errors = errors + data.error[i]+ '\n';  
          });
          
          if (data.fields != undefined) {
            
            $.each(data.fields, function(i) {
              
              $('#' +data.fields[i]).parent().find('label').addClass('error');
              $('#' +data.fields[i]).addClass('error').focus();
            });
          }
          
          var sMessage = '<div class="alert alert-error ajax-message"> '+
                         '  <button type="button" class="close" data-dismiss="alert">×</button>' +errors+ 
                         '</div>';
          
          $oFormErros.html(sMessage);
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      },
      error    : function(xhr, err, thrownError) {
        
        if (xhr.responseText) {
          
          var error = $.parseJSON($.trim(xhr.responseText));
          
          bootbox.alert(error.message);
          
          if (error.exception) {
            console.log(error.exception);
          }
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!<br>readyState: ' +xhr.readyState+ '<br>status: ' +xhr.status);
        }
        
        settings.eThis.attr('disabled', false);
      }
    });
    
    return false;
  });
});