$(function() {
  var $oFrmEmitirGuia        = $('#form_emitir_guia_dms');
  var $oBtnEmitirGuia        = $('#btn_emitir_guia');
  var $oBtnFecharModal       = $('.btn-fechar, .close');
  var $oModal                = $('#myModal');
  var $oElementosEvitarEnter = $('form input[type!="submit"], form select');

  // Previne submit ao pressionar 'Enter'
  $oElementosEvitarEnter.keypress(function(oEvento) {

    if (oEvento.which == 13) {
      oEvento.preventDefault();
    }
  });

  // Só habilita o botão ao abrir o formulario/modal
  $oBtnEmitirGuia.html('Gerar Guia').attr('disabled', false);

  /**
   * Geração de Guia
   */
  $oBtnEmitirGuia.click(function(e) {

    var textoBotao = $oBtnEmitirGuia.html();

    // Valida se o botão está desabilitado, pois uma guia está em processamento
    if ($('#btn_emitir_guia').is('[disabled=disabled]')) {
      return false;
    }

    $oBtnEmitirGuia.html('Aguarde...').attr('disabled', true);
    $oBtnFecharModal.attr('disabled', true);

    $oFrmEmitirGuia.submitForm({
      'eMessageContainer' : $('#form_emitir_guia_dms_erros'),
      'successCallback'   : function(data) {

        // Mantem o botão desabilitado
        $oBtnEmitirGuia.html(textoBotao);
        $oBtnFecharModal.attr('disabled', false);

        if (data.url) {
          $oModal.load('/contribuinte/guia/dms-gerar-modal/url_guia_pagamento/' +data.url);
        } else {
          bootbox.alert(data.success, function() { location.href = data.url; $oBtnBuscar.click(); });
        }
      },
      'completeCallback' : function() {
        $oBtnEmitirGuia.html(textoBotao);
        $oBtnFecharModal.attr('disabled', false);
      }
    });

    e.preventDefault();
    return false;
  });

  /**
   * Fechar o modal
   */
  $oBtnFecharModal.click(function() {
    $('body').remove('.modal-backdrop');
    window.location.reload();
  });

  $().addMascarasCampos();
});