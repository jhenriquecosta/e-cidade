$(function() {
  
  // Elementos
  var $oUsuario                   = $('#usuario');
  var $oDataProcessamentoInicial  = $("#data_processamento_inicial");
  var $oDataProcessamentoFinal    = $("#data_processamento_final");
  var $oElementosEvitarEnter      = $("form input[type!=submit], form select");
  var $oDivLista                  = $("#lista-ajax");
  var $oBtnConsultar              = $("#btn_consultar");
  var $oPaginacao                 = $("#lista-ajax .pagination ul li a, .lista-ordem");

  // Combobox editavel
  $oUsuario.combobox();
  
  // Previne submit ao pressionar 'Enter'
  $oElementosEvitarEnter.keypress(function(oEvento) {  
    
    if (oEvento.which == 13) {
      oEvento.preventDefault();
    }
  });
  
  // Configura o range entre a data inicial e final
  $oDataProcessamentoInicial.datepicker();
  $oDataProcessamentoFinal.datepicker();
  
  // Adiciona máscaras de data aos elementos
  $oDataProcessamentoInicial.setMask("date");
  $oDataProcessamentoFinal.setMask("date");
  
  /**
   * Efetua a consulta 
   */
  $oBtnConsultar.click(function(e) {
    var $oThis = $(this);
    var $oForm = $(this).closest("form");
    
    $oForm.ajaxForm({
      "url"          : $oForm.attr("action"),
      "data"         : $oForm.serialize(),
      "beforeSubmit" : function() {
        $oThis.attr("disabled", true);
        $oDivLista.html("<fieldset><img src='" +imagem_loading_gif+ "'> Efetuando consulta...</fieldset>");
      },
      "success"      : function(data) {
        $oDivLista.html(data);
      },
      "complete"     : function() {

        $oThis.attr("disabled", false);

        // Mostra as mensagem do protocolo
        $('.tooltip-modal').popover({
          placement : 'right',
          trigger   : 'hover',
          title     : 'Código/Mensagem',
          html      : true,
          template  : '<div class="popover popover-medium"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
        });
      }
    });
  });
  
  /**
   * Clique na paginação da lista de registros
   */
  $oPaginacao.live("click", function(e) {
    var $oThis = $(this);
    
    $.ajax({
      url        : $oThis.attr("href"),
      beforeSend : function() { 
        $oThis.attr("disabled", true);
        $oDivLista.find('table').find('tbody').find('tr').find('td').css({'color' : '#808080'});
      }
    }).always(function() {
      $oThis.attr("disabled", false);
    }).done(function(data) {
      $oDivLista.html(data);

      // Mostra as mensagem do protocolo
      $('.tooltip-modal').popover({
        placement : 'right',
        trigger   : 'hover',
        title     : 'Código/Mensagem',
        html      : true,
        template  : '<div class="popover popover-medium"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
      });
    });
    
    e.preventDefault();
  });
});