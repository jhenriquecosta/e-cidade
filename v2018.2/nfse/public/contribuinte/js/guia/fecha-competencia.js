$(function() {
  var $oFormCompetencia = $('form[name=fecharcompetencia]');
  var $oBtnFecharCompetencia = $('#btnFecharCompetencia');
  var $oBtnFecharModal = $('#ok-btn, .fechar');

  /**
   * Clique do botão fechar competência
   */
  $oBtnFecharCompetencia.live('click', function(e) {
    $oFormCompetencia.submit();
    e.preventDefault();
  });

  /**
   * Processa o submit do formulário via ajax
   */
  $oFormCompetencia.submit(function(e) {
    var $oModal = $('#myModal');
    var sTextoBtnFecharCompetencia = $oBtnFecharCompetencia.html();

    $oFormCompetencia.find('*').attr('readonly', true);
    $oBtnFecharModal.attr('disabled', true);
    $oBtnFecharCompetencia.attr('disabled', true).html('Aguarde...');

    $.ajax({
      type   : 'post',
      data   : $oFormCompetencia.serialize(),
      url    : $oFormCompetencia.attr('action'),
      success: function(data) {
        $oFormCompetencia.find('*').attr('readonly', false);
        $oBtnFecharCompetencia.attr('disabled', false).html(sTextoBtnFecharCompetencia);

        $oModal.html(data);

        var $oBtnFecharModal = $('#ok-btn, .fechar');
        $oBtnFecharModal.attr('disabled', false);
      },
      error  : function() {
        $oFormCompetencia.find('*').attr('readonly', false);
        $oBtnFecharModal.attr('disabled', false);
        $oBtnFecharCompetencia.attr('disabled', false);
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

  // Adiciona máscaras no campos
  $().addMascarasCampos();
});