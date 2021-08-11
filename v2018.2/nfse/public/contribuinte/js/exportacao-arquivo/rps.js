$(function() {

  var $oDivLista     = $('#lista-ajax');
  var $oBtnConsultar = $('#btn_consultar');
  var $oBtnExportar  = $('#btn_exportar');
  var $oPaginacao    = $('#lista-ajax .pagination ul li a, .lista-ordem');

  /**
   * Efetua a consulta por ajax
   */
  $oBtnConsultar.click(function(e) {

    var $oThis = $(this);
    var $oForm = $(this).closest('form');

    $.ajax({
      type       : 'POST',
      url        : $oForm.attr('action'),
      data       : $oForm.serialize(),
      beforeSend : function() {
        $oThis.attr('disabled', true);
        $oBtnExportar.attr('disabled', true);
        $oDivLista.html("<fieldset><img src='" +imagem_loading_gif+ "'> Efetuando consulta...</fieldset>");
      },
      success    : function(data) {
        $oDivLista.html(data);
      },
      complete   : function() {

        $oThis.attr('disabled', false);
        $oBtnExportar.attr('disabled', false);
        $oBtnExportar.removeClass('disabled disabled');

        /**
         * Mostra observações das notas substituidas e substitutas
         */
        $('.tooltip-modal').popover({
          placement : 'right',
          trigger   : 'hover',
          title     : 'Observações',
          html      : true
        });
      }
    });
  });

  /**
   * Exporta as notas para XML e executa o download do arquivo
   */
  $oBtnExportar.click(function(e) {

    var $oThis = $(this);
    var $oForm = $(this).closest('form');

    $.ajax({
      type       : 'POST',
      url        : '/contribuinte/exportacao-arquivo/rps-exportar/',
      data       : $oForm.serialize(),
      beforeSend : function() {
        $oThis.attr('disabled', true);
        $oThis.html('Aguarde...');
      },
      success    : function(data) {

        if (data.success) {

          bootbox.dialog(data.message, [{
            label : 'Cancelar',
            class : 'btn'
          }, {
            label    : 'Download',
            class    : 'btn-success',
            callback : function(e) {
              window.location.href = '/contribuinte/exportacao-arquivo/download/file/' + data.filename;
            }
          }], {
            backdrop : 'static',
            keyboard : false,
            show     : true
          });
        } else {

          var mensagem = (data.message) ? data.message : 'Verifique os filtros da consulta!';
          bootbox.alert(mensagem);
        }
      },
      complete   : function() {

        $oThis.attr('disabled', false);
        $oThis.html('Exportar');
      }
    });
  });

  /**
   * Clique na paginação da lista de registros
   */
  $oPaginacao.live('click', function(e) {

    var $oThis = $(this);
    $.ajax({
      url        : $oThis.attr('href'),
      beforeSend : function() {
        $oThis.attr('disabled', true);
        $oDivLista.find('table').find('tbody').find('tr').find('td').css({'color' : '#808080'});
      }
    }).always(function() {
      $oThis.attr('disabled', false);
    }).done(function(data) {

      $oDivLista.html(data);

      /**
       * Mostra observações das notas substituidas e substitutas
       */
      $('.tooltip-modal').popover({
        placement : 'right',
        trigger   : 'hover',
        title     : 'Observações',
        html      : true
      });
    });

    e.preventDefault();
  });
});