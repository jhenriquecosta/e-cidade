$(function() {
  var $oBtnSubmit = $('#btn_verificar');
  var $oBtnlink = $('.submit-link');
  var $oErrorList = $('.error-login-content');
  var $oErrorClose = $('.close');
  var $oErrorElm = $('.' + $oErrorClose.attr('data-dismiss'));
  var $oPrestadorCnpjCpf = $('input[name=prestador_cnpjcpf]');
  var $oCodigoVerificacao = $('input[name=codigo_verificacao]');

  // Preenche o campo de email pelo cookie
  if ($.cookie('prestador_cnpjcpf')) {

    $oPrestadorCnpjCpf.val($.cookie('prestador_cnpjcpf'));
    $oCodigoVerificacao.focus();
  } else {
    $oPrestadorCnpjCpf.focus();
  }

  // Cancela evento do elemento e redireciona para a url do elemento
  $oBtnlink.click(function(e) {

    location.href = $(this).attr('url');
    e.preventDefault();
  });

  // Submit do formulário
  $oBtnSubmit.click(function(e) {
    var $oElm = $(this);
    var $oForm = $oElm.closest('form');
    var $sText = $oElm.val();
    var $sTextLoading = $oElm.attr('data-loading-text');

    // Salva cookie com informacao do campo
    $.cookie('prestador_cnpjcpf', $oPrestadorCnpjCpf.val(), { expires: 30, path: '/' });

    // Processa o submit
    $.ajax({
      dataType  : 'json',
      url       : $oForm.attr('action'),
      data      : $oForm.serialize(),
      beforeSend: function() {

        $oElm.val($sTextLoading).attr('disabled', true);
        $oErrorElm.hide();
        $oErrorList.html('');
        $oForm.find('input').attr('readonly', true).addClass('readonly').removeClass('db-field-error');
        $oForm.find('label').removeClass('db-label-error');
        $oBtnlink.attr('disabled', true);
      },
      complete  : function() {

        $oElm.val($sText).attr('disabled', false);
        $oForm.find('input').attr('readonly', false).removeClass('readonly');
        $oBtnlink.attr('disabled', false);
      },
      success   : function(data) {

        if (data.status) {
          window.open(data.url, '_blank');
        } else if (data.error) {

          /** @namespace data.fields */
          if (data.fields != undefined) {

            $.each(data.fields, function(i) {

              $('#' + data.fields[i])
                .addClass('db-field-error')
                .focus()
                .prev('label').addClass('db-label-error');
            });
          }

          $.each(data.error, function(i) {
            $oErrorList.append('<li>' + data.error[i] + '</li>');
          });

          $oErrorElm.show();
        }
      },
      error     : function(xhr, ajaxOptions, thrownError) {

        $oErrorList.html('');
        $oErrorList.append('<li>Status: ' + xhr.status + '</li><li>Descrição: <code>' + thrownError + '</code></li>');
        $oErrorElm.show();
      }
    });

    e.preventDefault();
    return false;
  });

  // Evento para o botão de fechar na mensagem de erro do formulário
  $oErrorClose.click(function(e) {
    $oErrorElm.slideUp();
    e.preventDefault();
    return false;
  });
});