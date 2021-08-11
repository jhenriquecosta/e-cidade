$(function() {
  
  // Elementos
  var $oDataEmissaoInicial   = $("#data_competencia_inicial");
  var $oDataEmissaoFinal     = $("#data_competencia_final");
  var $oElementosEvitarEnter = $('form input[type!="submit"], form select');
  var $oBtnGerar             = $('#btn_gerar');
  
  // Previne submit ao pressionar 'Enter'
  $oElementosEvitarEnter.keypress(function(oEvento) {  
    
    if (oEvento.which == 13) {
      oEvento.preventDefault();
    }
  });
  
  // Adiciona máscaras de data aos elementos
  $oDataEmissaoInicial.setMask("19/2999");
  $oDataEmissaoFinal.setMask("19/2999");
  
  // Processa o formulario
  $oBtnGerar.click(function(e) {
    var $oThis      = $(this);
    var $oForm      = $(this).closest('form');
    var $oMessage   = $('.ajax-message-livro-fiscal');
    var sTextoBotao = $oThis.val(); 
    
    // Remove as mensagens de erro
    $oMessage.remove();
    
    $('input').removeClass('error');
    
    // Gerao livro fiscal
    $.ajax({
      'type'       : 'post',
      'dataType'   : 'json',
      'url'        : $oForm.attr('action'),
      'data'       : $oForm.serialize(),
      'beforeSend' : function() { 
        $oThis.attr('disabled', true);
        $oThis.val($oThis.attr('msg-loading'));
        $('<img class="imagem-loading" src=' +imagem_loading_gif+ ' style="margin-left:10px" />').insertAfter($oThis);
        
        $oForm.find('input').attr('disabled', true);
      },
      'complete'   : function() {
        $oThis.attr('disabled', false).val(sTextoBotao);
        $oForm.find('input').attr('disabled', false);
        $('.imagem-loading').remove();
      },
      'error'      : function(xhr, err) {
        bootbox.alert('Ocorreu um erro ao processar!<br>readyState: ' +xhr.readyState+ '<br>status: ' +xhr.status);
        $oThis.attr('disabled', false).val(sTextoBotao);
        $('.imagem-loading').remove();
      },
      'success'    : function(data) {
        if (data.status && data.success && data.url) {
          location.href = data.url;
        } else if (data.error) {
          
          var errors = '';
          
          $.each(data.error, function(i) {
            errors = errors + data.error[i]+ '\n';  
          });
          
          // Mostra a mensagem de erro
          $oForm.before('<div class="alert alert-error ajax-message-livro-fiscal"> '+
                         '  <button type="button" class="close" data-dismiss="alert">×</button>' +errors+ 
                         '</div>');
          
          // Classe de erro nos campos
          if (data.fields != undefined) {
            
            $.each(data.fields.reverse(), function(i) {
              
              $('#' +data.fields[i]).prev('label').addClass('error');
              $('#' +data.fields[i]).addClass('error');
              $('#' +data.fields[i]).focus();
            });
          }
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      }
    });
    
    e.preventDefault();
    return false;
  });
});