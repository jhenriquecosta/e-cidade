$(function() {
  var $oContainerMessage = $('#retorno-alert');
  var $oBtnProcessar = $('#processar');
  var $oForm         = $('#form_importacao_desif');

  $oContainerMessage.hide();

  $oBtnProcessar.click(function(e) {
    $oBtnProcessar.attr('disabled', true);
    $oBtnProcessar.val('Aguarde...');

    $oForm.ajaxForm({
        // crossDomain : true,
        // async       : false,
         async       : true,
         type        : 'post',
         dataType    : 'json',
        success     : function(data) {

          if (data.status && data.success) {

            sucessMessage = data.success + ' Protocolo: ' + data.protocolo;
            $oContainerMessage.addClass('alert alert-success');
            $oContainerMessage.prepend(sucessMessage);
            $oContainerMessage.show();
          } else if (data.error) {

            var erros = '';

            $.each(data.error, function(i) {
              erros = data.error[i]+ '\n';
            });

            erros += ' Protocolo: ' + data.protocolo;
            $oContainerMessage.addClass('alert alert-error');
            $oContainerMessage.prepend(erros);
            $oContainerMessage.show();
          } else {

            $oContainerMessage.addClass('alert alert-error');
            $oContainerMessage.prepend('Ocorreu um erro desconhecido!');
            $oContainerMessage.show();
          }

          $oBtnProcessar.attr('disabled', false);
          $oBtnProcessar.val('Processar');
        },
        error       : function(e) {

          $oBtnProcessar.attr('disabled', false);
          $oBtnProcessar.val('Processar');
        }
      });
  });
});

