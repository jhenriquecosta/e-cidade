$(function() {

  /**
   * Gera os botões de ações da consulta
   * @returns HTML
   */
  var getBotoesAcao = function(currentData) {

    var id          = currentData['id'],
        nota        = currentData['nota'],
        attrPadrao  = {
          'href':'#myModal',
          'data-toggle':'modal',
          'modal-width':'500',
          'modal-height':'auto',
          'data-id':id,
          'data-nota':nota
        },
        botoesAcoes = $('<span></span>')
      .append($('<a></a>')
        .attr(attrPadrao)
        .attr({
          'modal-url':'/fiscal/cancelamento-nfse/visualizar/id/' + id + '/nota/' + nota,
          'title':'Visualizar Nota'
        })
        .css({'margin': 1})
        .addClass('btn btn-mini')
        .append('<i class="icon-eye-open"></i>')
      ).append($('<a></a>')
        .attr({
          'data-id':id,
          'data-nota':nota,
          'title':'Confirmar Solicitação'
        })
        .css({'margin': 1})
        .addClass('btn btn-mini btn-success')
        .append('<i class="icon-ok icon-white"></i>')
      ).append($('<a></a>')
        .attr(attrPadrao)
        .attr({
          'modal-url':'/fiscal/cancelamento-nfse/rejeitar/id/' + id + '/nota/' + nota,
          'title':'Rejeitar Solicitação'
        })
        .css({'margin': 1})
        .addClass('btn btn-mini btn-danger')
        .append('<i class="icon-remove icon-white"></i>')
      ).html();

    return botoesAcoes;
  }

  /**
   * Cria e adiciona a grid no content da view
   */
  var oJqGrid = $().DBJqGrid({
    url         : '/fiscal/cancelamento-nfse/consultar',
    sortname    : 'e.id',
    sortorder   : 'asc',
    colNames    : [
      '-',
      'Nota',
      'Contribuinte',
      'CNPJ',
      'Data Solicitação',
      'Motivo',
      'Ação'
    ],
    colModel    : [
      {name:'id', hidden:true, sortable:false},
      {name:'nota',width:10, sortable:false, align:'center',
        formatter: function(cellvalue) {
          return '#' + cellvalue;
        }
      },
      {name:'nome_contribuinte',width:40, sortable:false},
      {name:'cnpj',width:15, sortable:false},
      {name:'dt_solicitacao',width:15, sortable:false, align:'center'},
      {name:'motivo_label',width:30, sortable:false},
      {name:'acao', width:10, sortable:false}
    ],
    afterInsertRow : function(id, currentData) {
      $(this).setCell(id, "acao", getBotoesAcao(currentData));
    },
    loadComplete   : function() {

      $(".btn-success").click(function(e) {
        e.preventDefault();

        if ( !$(this).is('[disabled=disabled]') )  {
          confirmaSolicitacao($(this).data('id'), $(this).data("nota"));
        }
      });
    }
  });

  var atualizarGrid = function() {

    oJqGrid.jqGrid("setGridParam", {
      datatype : "json"
    }).trigger("reloadGrid", [{current: true, page: oJqGrid.getGridParam('page')}]);
  }

  var confirmaSolicitacao = function(id, nota) {

    $(".btn-success").attr('disabled', true);
    $(".btn-danger").attr('disabled', true);
    $(".btn-mini").attr('disabled', true);

    bootbox.confirm('Realmente deseja aceitar o cancelamento da nota # '+ nota + '?', function(result) {
      if (result) {
        url ='/fiscal/cancelamento-nfse/confirmar/id/' + id;
        var $oTarget = $('div#mensagem-container');

        $.ajax({
          url: url,
          beforeSend : function () {

            var sMessage = '<div class="alert alert-alert ajax-message"> ' +
                             "  <button type='button' class='close' data-dismiss='alert'>×</button><img src='" +imagem_loading_gif+ "'> Aguarde...</div>";

            $oTarget.html(sMessage);
          },
          error : function(xhr, err) {

            if (xhr.responseText) {

              var error = $.parseJSON($.trim(xhr.responseText));

              bootbox.alert(error.exception.information);

              if (error.exception) {
                console.log(error.exception);
              }
            } else {
              bootbox.alert('Ocorreu um erro ao processar!<br>readyState: ' +xhr.readyState+ '<br>status: ' + xhr.status);
            }
            atualizarGrid();
          },
          success : function(data) {

            // Remove as classes de erro
            $oTarget.find('.error').removeClass('error');
            if (data && data.success) {

              var sMessage = '<div class="alert alert-success ajax-message"> ' +
                             '  <button type="button" class="close" data-dismiss="alert">×</button>' + data.success +
                             '</div>';

              $oTarget.html(sMessage);
            } else if (data && data.error) {

              var errors = '';

              $.each(data.error, function(i) {
                errors = errors + data.error[i]+ '\n';
              });

              var sMessage = '<div class="alert alert-error ajax-message"> ' +
                             '  <button type="button" class="close" data-dismiss="alert">×</button>' + errors +
                             '</div>';

              $oTarget.html(sMessage);
            } else {
              bootbox.alert('Ocorreu um erro desconhecido!');
            }
            atualizarGrid();
          }
        });
      } else {
        atualizarGrid();
      }
    });
  };
});
