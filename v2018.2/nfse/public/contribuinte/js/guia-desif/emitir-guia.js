$(function() {

  var $oFormEmitirGuia = $('form[name="formemitirguia"]');
  var $oBtnEmitirGuia  = $('#btn-emitir-guia');
  var $oBtnFecharModal = $('#ok-btn, .fechar');
  var $oModal = $('#myModal');

  $oBtnEmitirGuia.click(function(e) {

    var sTextoBtnFecharCompetencia = $oBtnEmitirGuia.html();

    $oFormEmitirGuia.find('*').attr('readonly', true);
    $oBtnFecharModal.attr('disabled', true);
    $oBtnEmitirGuia.attr('disabled', true).html('Aguarde...');

    $.ajax({
      type   : 'post',
      data   : $oFormEmitirGuia.serialize(),
      url    : $oFormEmitirGuia.attr('action'),
      success: function(data) {

        $oFormEmitirGuia.find('*').attr('readonly', false);
        $oBtnEmitirGuia.attr('disabled', false).html(sTextoBtnFecharCompetencia);

        $oModal.html(data);

        var $oBtnFecharModal = $('#ok-btn, .fechar');
        $oBtnFecharModal.attr('disabled', false);
      },
      error  : function() {

        $oFormEmitirGuia.find('*').attr('readonly', false);
        $oBtnFecharModal.attr('disabled', false);
        $oBtnEmitirGuia.attr('disabled', false);
      }
    });

    e.preventDefault();
  });

  /**
   * Botão Ok para fechar a janela, atualiza tela para visualizar o novo status
   */
  $oBtnFecharModal.click(function() {
    window.location.reload();
  });

  $().addMascarasCampos();
});