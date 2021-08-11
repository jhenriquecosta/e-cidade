$(function() {
  var $oBtnSalvarGeral   = $('#btn_salvar_geral');
  var $oBtnSalvarNfse    = $('#btn_salvar_nfse');
  var $oBtnSalvarRps     = $('#btn_salvar_rps');
  var $oBtnSincronizar   = $('#btn_atualizar');
  var $oOptModeloNfse    = $('#modelo_impressao_nfse');
  var $oImagemModeloNfse = $('#imagem-modelo');
  var $oImgModeloNfse    = $oImagemModeloNfse.find('img');
  var $oDivModeloNfse    = $('#modal-modelo-nfse');
  var $oInputImagem      = $('input[type=image]');
  
  $oInputImagem.click(function(e){
    e.preventDefault();
    return false;
  });
  
  // Mostra Imagem grande
  $oDivModeloNfse.on('show', function() {
    $oDivModeloNfse.find('.modal-body img').attr('src', $oImgModeloNfse.attr('src'));
    
    var sHeight = ($(document).height() - 100) + 'px';  
    
    $(this).find('.modal-body').css({ width : 'auto', height : sHeight, 'max-height' : sHeight });
  });
  
  // Mostra a imagem na troca de modelo de NFSE
  $oOptModeloNfse.change(function(e) {
    var numero_modelo = $(this).find(':selected').val();
    
    if (numero_modelo) {
      $oImgModeloNfse.attr('src', '/administrativo/img/nfse/modelo_' +numero_modelo+ '.png');
      $oImagemModeloNfse.removeClass('hide');
    } else {
      $oImagemModeloNfse.addClass('hide');
    }
  });
  $oOptModeloNfse.change();
  
  // Lanca Servico
  $oBtnSalvarGeral.click(function(e) {
    var $oThis    = $(this);
    var $oForm    = $(this).closest('form');
    var $oTarget  = $oForm.find('.form_erros');
    var txtElm    = $(this).val();
    
    // Remove as mensagens de erro
    $oTarget.html('');
    
    $.ajax({
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      beforeSend  : function() { $oThis.val('Aguarde...').attr('disabled', true); },
      complete    : function() { $oThis.val(txtElm).attr('disabled', false); },
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
         
        $oForm.find('.control-group').removeClass('error'); // Remove as classes de erro
         
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
              $('#' +data.fields[i]).closest('.control-group').addClass('error');
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
  
  // Lanca Servico
  $oBtnSalvarNfse.click(function(e) {
    var $oThis    = $(this);
    var $oForm    = $(this).closest('form');
    var $oTarget  = $oForm.find('.form_erros');
    var txtElm    = $(this).val();
    
    // Remove as mensagens de erro
    $oTarget.html('');
    
    $.ajax({
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      beforeSend  : function() { $oThis.val('Aguarde...').attr('disabled', true); },
      complete    : function() { $oThis.val(txtElm).attr('disabled', false); },
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
         
        $oForm.find('.control-group').removeClass('error'); // Remove as classes de erro
         
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
              $('#' +data.fields[i]).closest('.control-group').addClass('error');
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
  
  // Lanca Servico
  $oBtnSalvarRps.click(function(e) {
    var $oThis    = $(this);
    var $oForm    = $(this).closest('form');
    var $oTarget  = $('.form_erros_rps');
    var txtElm    = $(this).val();
    
    // Remove as mensagens de erro
    $oTarget.html('');
    
    $.ajax({
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      beforeSend  : function() { $oThis.val('Aguarde...').attr('disabled', true); },
      complete    : function() { $oThis.val(txtElm).attr('disabled', false); },
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
         
        $oForm.find('.control-group').removeClass('error'); // Remove as classes de erro
         
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
              $('#' +data.fields[i]).closest('.control-group').addClass('error');
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
  
  /**
   * Sincroniza dados
   */
  $oBtnSincronizar.click(function(e) {
    var $oThis    = $(this);
    var $oForm    = $(this).closest('form');
    var $oTarget  = $oForm.find('.form_erros');
    var txtElm    = $(this).val();
    
    // Remove as mensagens de erro
    $oTarget.html('');
    
    $.ajax({
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      beforeSend  : function() { $oThis.val('Aguarde...').attr('disabled', true); },
      complete    : function() { $oThis.val(txtElm).attr('disabled', false); },
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
         
        $oForm.find('.control-group').removeClass('error'); // Remove as classes de erro
         
        if (data && data.status && data.success) {
          
          if (data.dados != undefined) {
            $.each(data.dados, function(field, value) {
              
              if ($('#' +field).attr('type') == 'image') {
                var date = new Date();
                
                $('#' +field).attr('src', value + '?' +date.getTime());
              } else {
                $('#' +field).val(value);  
              }
            });
          }
          
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
              $('#' +data.fields[i]).closest('.control-group').addClass('error');
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