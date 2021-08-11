$(function() {

  var $oModal = $('#myModal');

  /**
   * Cria e adiciona a grid no content da view
   */
  $().DBJqGrid({
    url         : '/contribuinte/guia-desif/geracao',
    sortname    : 'e.id',
    sortorder   : 'asc',
    colNames    : [
      '-',
      'Competência Inicial',
      'Competência Final',
      'Total Serviços',
      'Total ISS',
      'Ação'
    ],
    colModel    : [
      {name:'id', hidden:true, sortable:false},
      {name:'competencia_inicial', width:20, sortable:false,
        formatter: function(cellvalue, options, rowObject) {
          return rowObject['competencia_inicial'].substr(0, 4) + '/' + rowObject['competencia_inicial'].substr(4, 2);
        }
      },
      {name:'competencia_final', width:20, sortable:false,
        formatter: function(cellvalue, options, rowObject) {
          return rowObject['competencia_final'].substr(0, 4) + '/' + rowObject['competencia_final'].substr(4, 2);
        }
      },
      {name:'total_receita', width:20, sortable:false},
      {name:'total_iss', width:20, sortable:false},
      {name:'acao', width:20, sortable:false, align: 'center'}
    ],
    afterInsertRow : function(id, currentData, jsondata) {

      if (!jsondata['guia_emitida']) {

        var $sBotoesAcoes = $('<span></span>')
          .append($('<button>Detalhes</button>')
            .attr({'href':'#','data-id':id})
            .css({'margin':1, })
            .addClass("btn btn-small btn-success btn-detalhes")
          ).append($('<button>Emitir Guia</button>')
             .attr({'href':'#myModal','data-id':id,'data-toggle':"modal"})
             .css({'margin':1})
             .addClass("btn btn-small btn-success btn-emitir")
          ).html();

      } else {

        var $sBotoesAcoes = $('<span></span>')
          .append($('<button>Detalhes</button>')
            .attr({'href':'#','data-id':id})
            .css({'margin':1})
            .addClass("btn btn-small btn-success btn-detalhes")
          ).append($('<button>Guia Emitida</button>')
             .css({'margin':1, 'disabled': 'disabled'})
             .addClass("btn btn-small btn-info")
          ).html();
      }

      $(this).setCell(id, "acao", $sBotoesAcoes);
    },
    loadComplete   : function() {

      $(".btn-detalhes").click(function(e) {
        e.preventDefault();
        $sUrl = '/contribuinte/guia-desif/geracao-detalhes/id/' + $(this).data("id");
        $(location).attr('href', $sUrl);
      });

      $(".btn-emitir").click(function(e) {
        $.ajax({
          type : 'GET',
          data : {'id':$(this).data("id")},
          url  : '/contribuinte/guia-desif/emitir-guia'
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