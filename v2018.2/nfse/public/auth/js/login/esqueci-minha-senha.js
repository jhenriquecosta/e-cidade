$(function() {
  var $oBtnSubmit         = $('#submit');
  var $oBtnlink           = $('.submit-link');
  var $oErrorList         = $('.error-login-content');
  var $oErrorClose        = $('.close');
  var $oErrorElm          = $('.' +$oErrorClose.attr('data-dismiss'));
  var $oCpfCnpj           = $('input[name=email]');
  
  // Foco no campo CPF / CNPJ
  $oCpfCnpj.focus();
  
  // Cancela evento do elemento e redireciona para a url do elemento
  $oBtnlink.click(function(e) {
    location.href = $(this).attr('url');
    e.preventDefault();
  });
  
  // Submit
  $oBtnSubmit.click(function(e) {
    $oElm         = $(this);
    $oForm        = $oElm.closest('form');
    $sText        = $oElm.val();
    $sTextLoading = $oElm.attr('data-loading-text');
    
    $.ajax({
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      beforeSend  : function() { 
        
        $oElm.val($sTextLoading).attr('disabled', true);
        $oForm.find('input').attr('readonly', true).addClass('readonly');
        $oBtnlink.attr('disabled', true);
      },
      complete    : function() {
        
        $oElm.val($sText).attr('disabled', false);
        $oForm.find('input').attr('readonly', false).removeClass('readonly');
        $oBtnlink.attr('disabled', false);
      },
      success     : function(data) {
        $oErrorElm.hide();
        $oErrorList.html('');
        $oForm.children().removeClass('error');
        
        if (data.status) {
          bootbox.alert(data.success, function() { location.href = data.url; });
        } else if (data.error) {
          
          if (data.fields != undefined) {
            $.each(data.fields, function(i) {
              $('#' +data.fields[i]).prev('label').addClass('error');
              $('#' +data.fields[i]).addClass('error');
            });
          }
          
          $.each(data.error, function(i) {
            $oErrorList.append('<li>' +data.error[i]+ '</li>');  
          });
          
          $oForm.find('input:first').focus();
          
          $oErrorElm.show();
        }
      },
      error    : function (xhr, ajaxOptions, thrownError) {
        $oErrorList.html('');
        $oErrorList.append('<li>Status: ' +xhr.status+ '</li><li>Descrição: <code>' +thrownError+ '</code></li>');
        $oErrorElm.show();
      }
    });
    
    e.preventDefault();
    return false;
  });
  
  $oErrorClose.click(function(e) {
    $oErrorElm.slideUp();
    e.preventDefault();
    return false;
  });
});
