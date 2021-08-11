$(function() {
  
  // Elementos
  var $oDataEmissaoInicial   = $("#data_emissao_inicial");
  var $oDataEmissaoFinal     = $("#data_emissao_final");
  var $oCpfCnpjTomador       = $("#cpfcnpj");
  var $oRazaoSocialTomador   = $("#s_razao_social");
  var $oElementosEvitarEnter = $("form input[type!=submit], form select");
  var $oDivLista             = $("#lista-ajax");
  var $oBtnConsultar         = $("#btn_consultar");
  var $oPaginacao            = $("#lista-ajax .pagination ul li a, .lista-ordem");

  // Previne submit ao pressionar 'Enter'
  $oElementosEvitarEnter.keypress(function(oEvento) {  
    
    if (oEvento.which == 13) {
      oEvento.preventDefault();
    }
  });
  
  // Configura o range entre a data inicial e final
  $oDataEmissaoInicial.datepicker({
    "onClose" : function(dataSelecionada) {
      
      $oDataEmissaoFinal.datepicker("option", "minDate", dataSelecionada);
      
      $oValorData = $oDataEmissaoInicial.val();
      
      var dia         = $oValorData.substr(0,2);
      var barra1      = $oValorData.substr(2,1);
      var mes         = $oValorData.substr(3,2);
      var barra2      = $oValorData.substr(5,1);
      var ano         = $oValorData.substr(6,4);
      
      if ($oValorData.length != 10 ||
          barra1 != "/" || barra2 != "/"   ||
          isNaN(dia)    || isNaN(mes)      || 
          isNaN(ano)    || dia>31          ||
          mes>12){
        
        $oDataEmissaoInicial.val('');
      }
    }
  });
  
  $oDataEmissaoFinal.datepicker({
    "onClose" : function(dataSelecionada) {
      $oDataEmissaoInicial.datepicker("option", "maxDate", dataSelecionada);
      
      $oValorData = $oDataEmissaoFinal.val();
      
      var dia         = $oValorData.substr(0,2);
      var barra1      = $oValorData.substr(2,1);
      var mes         = $oValorData.substr(3,2);
      var barra2      = $oValorData.substr(5,1);
      var ano         = $oValorData.substr(6,4);
      
      if ($oValorData.length != 10 ||
          barra1 != "/" || barra2 != "/"   ||
          isNaN(dia)    || isNaN(mes)      || 
          isNaN(ano)    || dia>31          ||
          mes>12){
        
        $oDataEmissaoFinal.val('');
      }
    }
  });
  
  // Adiciona máscaras de data aos elementos
  $oDataEmissaoInicial.setMask("date");
  $oDataEmissaoFinal.setMask("date");
  
  /**
   * Busca razão social do Tomador
   */
  $oCpfCnpjTomador.bind("blur", function(oEvento) {
    
    var $oThis   = $(this);
    var sUrl     = $oThis.attr("data-url");
    var sCpfCnpj = $oThis.val();
    
    $.ajax({
      "url"        : sUrl,
      "data"       : { "term" : sCpfCnpj },
      "beforeSend" : function() {
        $oThis.attr("disabled", true);
        $oBtnConsultar.attr("disabled", true);
        $oRazaoSocialTomador.val("");
      },
      "complete"   : function() {
        $oThis.attr("disabled", false);
        $oBtnConsultar.attr("disabled", false);
      },
      "success"    : function(data) {
        if (data && data[0].nome) {
          $oRazaoSocialTomador.val(data[0].nome);
        } else {
          $oRazaoSocialTomador.val("");
        }
      }
    });
  });
  
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

        // Mostra observações das notas substituidas e substitutas
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

      // Mostra observações das notas substituidas e substitutas
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