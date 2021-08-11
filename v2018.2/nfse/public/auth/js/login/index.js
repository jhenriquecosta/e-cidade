$(function() {
  var $oBtnSubmit  = $('#submit');
  var $oBtnlink    = $('.submit-link');
  var $oErrorList  = $('.error-login-content');
  var $oErrorClose = $('.close');
  var $oErrorElm   = $('.' +$oErrorClose.attr('data-dismiss'));
  var $oLogin      = $('input[name=login]');
  var $oSenha      = $('input[name=senha]');

  // Preenche o campo de email pelo cookie
  if ($.cookie('login')) {
    $oLogin.val($.cookie('login'));
    $oSenha.focus();
  } else {
    $oLogin.focus();
  }

  var recarrega = function() {
    location.reload(true);
  }

  // Submit
  $oBtnSubmit.click(function(e) {


    if ($('#recaptcha_response_field') && $('#recaptcha_response_field').val() == '') {
      return false;
    }
    $oElm         = $(this);
    $oForm        = $oElm.closest('form');
    $sText        = $oElm.val();
    $sTextLoading = $oElm.attr('data-loading-text');

    // Salva cookie com informacao do campo
    $.cookie('login', $oLogin.val(), { expires: 30, path: '/' });

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

        if (data.status) {

          $oErrorElm.hide();
          location.href = data.url;
        } else if (data.error) {

          $oErrorList.html('');

          if (data.fields != undefined) {

            $.each(data.fields.reverse(), function(i) {

              if(data.fields[i] == 'Captcha') {

                $('#Captcha-input').prev('label').addClass('error');
                $('#Captcha-input').addClass('error');
                $('#Captcha-input').focus();
              } else {

                $('#' +data.fields[i]).prev('label').addClass('error');
                $('#' +data.fields[i]).addClass('error');
                $('#' +data.fields[i]).focus();

              }
            });
          }

          $.each(data.error, function(i) {
            $oErrorList.append('<li>' +data.error[i]+ '</li>');
          });

          $('#error-login').show();

          if (data.bloqueado || data.captcha) {

            iTempoBloqueio = (1000 * 60 * data.tempo_bloqueio);
            $('#Captcha-input-label').hide();
            $('#Captcha-element').hide();
            $('#form_login').hide();

            setTimeout(function() {

              $('#Captcha-input-label').show();
              $('#Captcha-element').show();
              $('#form_login').show();
              recarrega();
            }, iTempoBloqueio);
          }
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
