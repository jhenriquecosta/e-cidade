$(function() {
  var $oBtnlink          = $('.submit-link');
  var $oBtnConfirmar     = $("#confirmar");
  var $oForm             = $oBtnConfirmar.closest('form');
  var $oTxtSenha         = $('#senha');
  var $oTxtSenhaRepetida = $('#senharepetida');
  var $oErrosAjax        = $('#erros');
  
  // Cancela evento do elemento e redireciona para a url do elemento
  $oBtnlink.click(function(e) {
    
    location.href = $(this).attr('url');
    e.preventDefault();
  });
  
  // Envio do formulário
  $oBtnConfirmar.click(function(e) {
    
    // Valida o tamanho das senha e criptografa
    var iTamanhoMininoSenha = $oTxtSenha.attr('minlength');
    var sMensagemErro       = $oTxtSenha.attr('message-error');
    
    $oTxtSenha.closest('.control-group').removeClass('error');
    $oTxtSenhaRepetida.closest('.control-group').removeClass('error');
    
    if ($oTxtSenha.val().length < iTamanhoMininoSenha || $oTxtSenhaRepetida.val().length < iTamanhoMininoSenha) {
      
      $oErrosAjax.mostrarDivErro({ 'mensagem' : sMensagemErro });
      $oTxtSenha.closest('.control-group').addClass('error');
      $oTxtSenhaRepetida.closest('.control-group').addClass('error');
      
      return false;
    } 
    
    if ($oTxtSenha.val() != $oTxtSenhaRepetida.val()) {
      
      $oErrosAjax.mostrarDivErro({ 'mensagem' : 'As senhas informadas não conferem.'});
      $oTxtSenha.closest('.control-group').addClass('error');
      $oTxtSenhaRepetida.closest('.control-group').addClass('error');
      return false;
    }
    
    $oTxtSenha.val(CryptoJS.SHA1($oTxtSenha.val()));
    $oTxtSenhaRepetida.val(CryptoJS.SHA1($oTxtSenhaRepetida.val()));
    // Envia o formulário
    $oForm.submitForm({
      'eMessageContainer' : $oErrosAjax,
      'completeCallback'  : function(data) {
        
        // Desbloqueia os campos no submit
        $oForm.find('input').attr('readonly', false);
        $oBtnlink.attr('disabled', false);
        var oRetorno = $.parseJSON($.trim(data.responseText));
        if (!oRetorno.status) {
          
          $oTxtSenha.val('');
          $oTxtSenhaRepetida.val('');
        } else {
          $.cookie('login', oRetorno.login , { expires: 30, path: '/' });  
        }
      }
    });
    
    return false;
  });
});