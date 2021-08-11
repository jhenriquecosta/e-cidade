/**
 * Script para geração do relatório 6
 *
 * @see /public/fiscal/relatorios/script-compartilhado.js Script compartilhado entre os relatórios
 */
$(function() {

  // Elementos
  var $oPrestadorCnpj        = $("#prestador_cnpj");
  var $oPrestadorRazaoSocial = $("#prestador_razao_social");
  var $oCompetenciaInicial   = $('#data_competencia_inicial');

  /**
   * Busca razão social do Prestador
   */
  var $oPrestadorRazaoSocialSpan = $("<span id='prestador_razao_social'/>").css({"padding" : "20px", "color":"#777"});

  $oPrestadorCnpj.closest('.controls').append($oPrestadorRazaoSocialSpan);
  $oPrestadorCnpj.bind("blur", function() {

    var $oThis = $(this);

    if ($oThis.val() === '') {

      $oPrestadorRazaoSocial.val('');
      $oPrestadorRazaoSocialSpan.html('');
      return false;
    }

    $.ajax({
      "url"        : $oThis.attr("data-url"),
      "data"       : { "term" : $oThis.val() },
      "beforeSend" : function() {

        $oPrestadorRazaoSocial.val('');
        $oPrestadorRazaoSocialSpan.html('');
        $oThis.addClass("db-input-loading-right").attr("disabled", true);
      },
      "complete"   : function() {
        $oThis.removeClass("db-input-loading-right").attr("disabled", false);
      },
      "success"    : function(data) {

        if (data && data[0].nome) {

          $oPrestadorRazaoSocial.val(data[0].nome);
          $oPrestadorRazaoSocialSpan.html(data[0].nome);
          $oCompetenciaInicial.focus();
        } else {

          $oPrestadorRazaoSocial.val('');
          $oPrestadorRazaoSocialSpan.html('');
          $oThis.focus();
        }
      }
    });
  });
});