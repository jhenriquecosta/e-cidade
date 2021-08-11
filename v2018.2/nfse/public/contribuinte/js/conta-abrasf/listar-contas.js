$(function() {

  var $aRowsToColor = [];

  /**
   * Cria e adiciona a grid no content da view
   */
  $().DBJqGrid({
    url         : '/contribuinte/conta-abrasf/listar-contas',
    sortname    : 'e.id',
    sortorder   : 'asc',
    colNames    : [
      '-',
      '-',
      'Conta Abrasf',
      'Titulo Contábil',
      'Tributável'
    ],
    colModel    : [
      {name:'id', hidden:true, sortable:false},
      {name:'obrigatorio', hidden:true, sortable: false, align:'center', width: 15,
        formatter: function(cellvalue, options, rowObject) {
          if (rowObject['obrigatorio']) {
            $aRowsToColor[$aRowsToColor.length] = {rowId:options.rowId, value:rowObject.obrigatorio};
          }

          return rowObject['obrigatorio'];
        }
      },
      {name:'conta_abrasf', width:25, sortable:false},
      {name:'titulo_contabil_desc', align:'left', width:180, sortable:false},
      {name:'tributavel', width:25, align:'center', sortable:false,
        formatter: function(cellvalue, options, rowObject) {
          return (rowObject['tributavel']) ? 'Sim' : 'Não';
      }}
    ],
    loadComplete: function() {

      /**
       * Altera a cor da linha dos tributáveis
       */
      $.each($aRowsToColor, function(index, data) {

        if (data.value) {
          $("#" + data.rowId).find("td").css("background", "#98CDEF");
        }
      });
    }
  });
});