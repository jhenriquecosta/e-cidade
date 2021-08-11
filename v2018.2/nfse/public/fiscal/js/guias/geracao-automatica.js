$(function() {

  var $oDivLista     = $('#lista-ajax');
  var $oBtnConsultar = $('#btn_consultar');
  var $oBtnGerar     = $('#btn_gerar');
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
        $oBtnGerar.attr('disabled', true);
        $oDivLista.html("<fieldset><img src='" +imagem_loading_gif+ "'> Efetuando consulta...</fieldset>");
      },
      success    : function(data) {
        $oDivLista.html(data);
      },
      complete   : function() {

        $oThis.attr('disabled', false);
        $oBtnGerar.attr('disabled', false);
        $oBtnGerar.removeClass('disabled disabled');
      }
    });
  });

  /**
   * Gerar as guias em aberto por competência
   */
  $oBtnGerar.click(function(e) {

    var $oThis          = $(this);
    var $oForm          = $(this).closest('form');

    bootbox.confirm('Deseja gerar as guias?', 'Não', 'Sim', function(confirmed) {

      if (confirmed) {

        $.ajax({
          type       : 'POST',
          url        : '/fiscal/guias/gerar',
          data       : $oForm.serialize(),
          beforeSend : function() {

            $oThis.attr('disabled', true);
            $oThis.html('Aguarde...');
            loadingMask($oDivLista.find('fieldset'));
          },
          success    : function(data) {

            if (data.success) {

              /**
               * Para uso como debug de retorno do e-cidade
               */
              //console.log(data.retorno_ecidade);
              bootbox.alert(data.message, function() {
                window.location.reload();
              });
            } else {

              var mensagem = (data.message) ? data.message : 'Verifique os filtros da consulta!';
              bootbox.alert(mensagem, function(){
                $('.modal-backdrop').remove();
              });
            }
          },
          complete   : function() {

            $oThis.attr('disabled', false);
            $oThis.html('Gerar');
            loadingMask(false);
          }
        });
      }
    });
  });

  /**
   * Clique na paginação da lista de registros
   */
  $oPaginacao.live('click', function(e) {

    var $oThis = $(this);
    var $tBody = $oDivLista.find('table').find('tbody');
    $.ajax({
      url        : $oThis.attr('href'),
      beforeSend : function() {

        $oThis.attr('disabled', true);
        $tBody.find('tr').find('td').css({'color' : '#808080'});
      }
    }).always(function() {
      $oThis.attr('disabled', false);
    }).done(function(data) {
      $oDivLista.html(data);
    });

    e.preventDefault();
  });

  /**
   * Monta o loading mask para bloqueio da tela
   * @param object $oElement
   */
  var loadingMask = function ($oElement) {

    var $oModalBackdrop     = $('<div>', {'class': 'modal-backdrop fade in'});
    var $oDivAjaxLoader     = $('<div>', {'id': 'ajax-loader'});
    var $oDivAjaxLoaderMask = $('<div>', {'class': 'ajax-loader-mask'});
    var $oImageLoader       = $('<img>', {'src': imagem_loading_mask_gif});

    if ($oElement) {

      $oDivAjaxLoaderMask.append($oImageLoader);
      $oDivAjaxLoader.append($oDivAjaxLoaderMask);
      $oModalBackdrop.append($oDivAjaxLoader);
      $oElement.append($oModalBackdrop);
    } else {
      $('#ajax-loader').remove();
    }
  }
});