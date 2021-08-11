$(function() {
  var $oFormCompetencia = $('form[name="fecharcompetencia"]');
  var $oBtnFechar = $('#fechar');
  var $oBtnFecharModal = $('#ok-btn, #btnClose');

  /**
   * Clique do botão reemitir guia
   */
  $oBtnFechar.click(function(e) {
    $oFormCompetencia.submit();
    e.preventDefault();
  });

  /**
   * Processa o submit do formulário via ajax
   */
  $oFormCompetencia.submit(function(e) {
    var $oModal = $('#myModal');

    $oFormCompetencia.find('*').attr('readonly', true);
    $oBtnFechar.attr('disabled', true);
    $oBtnFecharModal.attr('disabled', true);

    $.ajax({
      type      : 'post',
      data      : $(this).serialize(),
      url       : $(this).attr('action'),
      success   : function(data) {
        $oFormCompetencia.find('*').attr('readonly', false);
        $oBtnFechar.attr('disabled', false);

        $oModal.html(data);

        var $oBtnFecharModal = $('#ok-btn, #btnClose');
        $oBtnFecharModal.attr('disabled', false);
      },
      error     : function() {
        $oFormCompetencia.find('*').attr('readonly', false);
        $oBtnFechar.attr('disabled', false);
        $oBtnFecharModal.attr('disabled', false);
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