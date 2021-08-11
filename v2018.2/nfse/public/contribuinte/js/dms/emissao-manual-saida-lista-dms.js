$(function() {
  var $oBtnExcluirDms = $('.btn_excluir');
  var $oBtnFecharDms  = $('.btn_fechar');
  
  $oBtnExcluirDms.live('click', function(e) {
    var $oThis = $(this);
    
    bootbox.confirm('Confirma a exclusão?', function(bResult) {
      if (bResult) {
        $.ajax({
          dataType    : 'json',
          url         : $oThis.attr('href'),
          beforeSend  : function() { $oThis.attr('disabled', true);  },
          complete    : function() { $oThis.attr('disabled', false); },
          error       : function(xhr, err) {
            bootbox.alert('Ocorreu um erro ao processar!<br>readyState: ' +xhr.readyState+ '<br>status: ' +xhr.status);
            $oThis.attr('disabled', false);
          },
          success     : function(data) {
            if (data.status && data.success) {
              bootbox.alert(data.success, function () { location.reload(); });
            } else if (data.error) {
              bootbox.alert(data.error);
            } else {
              bootbox.alert('Ocorreu um erro desconhecido!');
            }
          }
        });
      }
    });
    
    e.preventDefault();
    return false;
  });
  
  //Fechar DMS
  $oBtnFecharDms.click(function(e) {
    var $oThis = $(this);
    
    $.ajax({
      dataType    : 'json',
      url         : $oThis.attr('href'),
      beforeSend  : function() { $oThis.attr('disabled', true);  },
      complete    : function() { $oThis.attr('disabled', false); },
      error       : function(xhr, err) {
        bootbox.alert('Ocorreu um erro ao processar!<br>readyState: ' +xhr.readyState+ '<br>status: ' +xhr.status);
        $oThis.attr('disabled', false);
      },
      success     : function(data) {
        if (data.status && data.success && data.url) {
          bootbox.alert(data.success, function () { 
            location.reload();
          });
        } else if (data.error) {
          bootbox.alert(data.error);
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      }
    });
    
    e.preventDefault();
    return false;
  });
});