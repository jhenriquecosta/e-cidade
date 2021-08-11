$(function() {
  var $oBtnlink = $('.submit-link');
  var $oForm = $('#formLiberacaoUsuario');
  var $oBtnConfirmar = $("#confirmar");
  var $oTxtSenha = $('#senha');
  var $oTxtSenhaRepetida = $('#senharepetida');

  /**
   * Cancela evento do elemento e redireciona para a url do elemento
   */
  $oBtnlink.click(function(e) {

    location.href = $(this).attr('url');
    e.preventDefault();
  });

  /**
   * Envio do formulário
   */
  $oBtnConfirmar.click(function() {
    var $oErro = $('#erros');
    var iTamanhoMininoSenha = $oTxtSenha.attr('minlength');
    var sMensagemErro = $oTxtSenha.attr('message-error');

    $oTxtSenha.closest('.control-group').removeClass('error');
    $oTxtSenhaRepetida.closest('.control-group').removeClass('error');

    // Valida o tamanho da senha
    if ($oTxtSenha.val().length < iTamanhoMininoSenha || $oTxtSenhaRepetida.val().length < iTamanhoMininoSenha) {

      $oErro.mostrarDivErro({ 'mensagem': sMensagemErro });
      $oTxtSenha.closest('.control-group').addClass('error');
      $oTxtSenhaRepetida.closest('.control-group').addClass('error');

      return false;
    }

    $oTxtSenha.val(CryptoJS.SHA1($oTxtSenha.val()));
    $oTxtSenhaRepetida.val(CryptoJS.SHA1($oTxtSenhaRepetida.val()));

    // Processa o forumulário
    $oForm.submitForm({
      'eMessageContainer': $('#erros'),
      'completeCallback' : function(data) {

        // Desbloqueia os campos no submit
        $oForm.find('input').attr('readonly', false);
        $oBtnlink.attr('disabled', false);
        var oRetorno = $.parseJSON($.trim(data.responseText));
        if (!oRetorno.status) {

          $('#senha').val('');
          $('#senharepetida').val('');
        }
      }
    });

    return false;
  });
});
