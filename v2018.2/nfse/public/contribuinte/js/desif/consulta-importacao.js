$(function() {

  var $oBtnConsultar      = $("#btn_consultar");
  var $oForm              = $("#form_consulta");

  /**
   * Cria e adiciona a grid no content da view
   */
  var $oJqGrid = $().DBJqGrid({
    url         : '/contribuinte/desif/listar-importacao-desif',
    sortname    : 'e.id',
    sortorder   : 'asc',
    postData    : { form:$oForm.closest('form').serializeObject() },
    colNames    : [
      '-',
      'Competência Inicial',
      'Competência Final',
      'Data/Hora',
      'Ação'
    ],
    colModel    : [
      {name:'id', hidden:true, sortable:false},
      {name:'competencia_inicial', align:'center', width:25, sortable:false},
      {name:'competencia_final', align:'center', width:25, sortable:false},
      {name:'data_hora', align:'center', width:25, sortable:false},
      {name:'acao', align:'center', width:10, sortable:false}
    ],
    afterInsertRow : function(id, currentData, jsondata) {

      var $sBotoesAcoes = $('<span></span>')
        .append($('<button>Imprimir</button>')
          .attr({'href':'#','data-id':id})
          .css({'margin':1})
          .addClass("btn btn-small btn-success btn-imprimir")
        ).html();

      $(this).setCell(id, "acao", $sBotoesAcoes);
    },
    loadComplete : function () {

      $(".btn-imprimir").click(function(e) {
        e.preventDefault();
        $sUrl = '/contribuinte/desif/imprime-importacao/id/' + $(this).data("id");
        $(location).attr('href', $sUrl);
      });
    }
  });

  /**
   * Atualiza os dados da grid
   */
  var atualizarGrid = function() {

    $oJqGrid.jqGrid("setGridParam", {
      datatype : "json",
      postData : { form:$oForm.closest('form').serializeObject() }
    }).trigger("reloadGrid", [{current: true, page: $oJqGrid.getGridParam('page')}]);
  }

  /**
   * Efetua a consulta
   */
  $oBtnConsultar.click(function(){
    atualizarGrid();
  });
});