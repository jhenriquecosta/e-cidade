$(function() {

  /**
   * Cria e adiciona a grid no content da view
   */
  $().DBJqGrid({
    url         : '/contribuinte/guia-desif/consulta-emissao',
    sortname    : 'e.id',
    sortorder   : 'asc',
    colNames    : [
      '-',
      'Competência',
      'Data Vencimento',
      'Valor Corrigido',
      'Valor Histórico',
      'Situação' ,
      'Ação'
    ],
    colModel    : [
      {name:'id', hidden:true, sortable:false},
      {name:'competencia', width:20, sortable:false,
        formatter: function(cellvalue, options, rowObject) {
          return rowObject['competencia_label'];
        }
      },
      {name:'data_vencimento', width:20, sortable:false},
      {name:'valor_corrigido', width:20, sortable:false},
      {name:'valor_historico', width:20, sortable:false},
      {name:'situacao', width:20, sortable:false, align: 'center',
        formatter: function(cellvalue, options, rowObject) {
          return (rowObject['situacao_label']) ? rowObject['situacao_label'] : '-';
        }
      } ,
      {name:'acao', width:20, sortable:false, align: 'center'}
    ],
    afterInsertRow : function(id, currentData, jsondata) {

      /**
       * Verifica se a situação da guia está em aberto
       */
       if (jsondata.situacao && jsondata.situacao == "a") {

         var $sBotoesAcoes = $('<span></span>')
           .append($('<button>Imprimir</button>')
             .attr({'href':'#','data-id':id})
             .css({'margin':1})
             .addClass("btn btn-small btn-success btn-imprimir")
           ).html();

         $(this).setCell(id, "acao", $sBotoesAcoes);
       }
    },
    loadComplete   : function() {

      var $oModal = $('#myModal');

      $(".btn-imprimir").click(function(e) {
         $.ajax({
           type : 'GET',
           data : {'guia':$(this).data("id")},
           url  : '/contribuinte/guia-desif/reemitir/'
         })
         .done(function( data ) {
             $oModal.html(data);
             $oModal.modal();
         });
         e.preventDefault();
      });

    }
  });
});