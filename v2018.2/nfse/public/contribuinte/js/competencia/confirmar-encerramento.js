$(function(){

  var oFormCompetencia        = $('#encerramentocompetencia');
  var oDivGuiaEmitida         = $('#divGuiaEmitida');
  var oDivFormEncerramento    = $('#divFormEncerramentoCompetencia');
  var oDivErro                = $('#divErro');
  var oDivSucesso             = $('#divSucesso');
  var oBotaoBaixarGuia        = $('#btnBaixarGuia');
  var oBtnEncerrarCompetencia = $('#btnEncerrarCompetencia');
  var oBtnFecharModal         = $('.fechar');
  var oBtnFechar              = $('#btnFechar');
  var oBtnCancelar            = $('#btnCancelar');
  var oMensagemAlerta         = $('#mensagemAlerta');
  var oMensagemSituacao       = $('#mensagemSituacao');

  oBtnEncerrarCompetencia.live('click', function(e){

    var oModal = $('#myModal');
    var sTextoBtnFecharCompetencia = oBtnEncerrarCompetencia.html();

    /**
     * Desabilitamos os componentes da modal enquando a requisição estiver em processamento
     */
    oFormCompetencia.find('*').attr('readonly', true);
    oBtnFecharModal.attr('disabled', true);
    oBtnEncerrarCompetencia.attr('disabled', true).html('Aguarde...');

    $.ajax({
      type   : 'post',
      data   : oFormCompetencia.serialize(),
      url    : oFormCompetencia.attr('action'),
      success: function(data){

        oFormCompetencia.find('*').attr('readonly', false);
        oBtnEncerrarCompetencia.attr('disabled', false).html(sTextoBtnFecharCompetencia);
        oBtnFecharModal.attr('disabled', false);

        oBtnEncerrarCompetencia.hide();
        oBtnFecharModal.show();
        oBtnCancelar.hide();
        oFormCompetencia.hide();
        oMensagemAlerta.hide();
        oMensagemSituacao.hide();

        if(data.lErro){

          oDivErro.html(data.sMensagemRetorno);
          oDivErro.show();

        }else{

          oDivFormEncerramento.hide();
          oDivGuiaEmitida.show();
          oDivSucesso.html(data.sMensagemRetorno);

          /**
           * Caso venha o arquivo da guia, o disponibilizamos para download
           */
          if(data.sArquivoGuia){

            /**
             * Concatenamos o nome do arquivo o valor já existente em href,
             * pois este contém a rota do controller que executa o download
             */
            var sCaminhoArquivo = oBotaoBaixarGuia.attr('href') + data.sArquivoGuia;

            oBotaoBaixarGuia.attr('href', sCaminhoArquivo);
            oBotaoBaixarGuia.show();
          }
        }
      },
      error  : function(){

        oFormCompetencia.find('*').attr('readonly', false);
        oBtnFecharModal.attr('disabled', false);
        oBtnEncerrarCompetencia.attr('disabled', false);

        oBtnEncerrarCompetencia.hide();
        oBtnFecharModal.show();
        oBtnCancelar.hide();
        oFormCompetencia.hide();
        oMensagemAlerta.hide();
        oMensagemSituacao.hide();

        var sMensagem = "Ocorreu uma erro inesperado na requisição do encerramento de competência.";
        oDivErro.html(sMensagem);
        oDivErro.show();
      }
    });
  });

  /**
   * Botão Ok para fechar a janela, atualiza tela para visualizar o novo status
   */
  oBtnFecharModal.click(function() {
    window.location.reload();
  });
});