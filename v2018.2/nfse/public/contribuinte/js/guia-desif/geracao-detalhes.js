$(function() {

  /**
   * Cria e adiciona a grid no content da view
   */
  $().DBJqGrid({
    url         : $(location).attr('pathname'),
    sortname    : 'e.id',
    sortorder   : 'asc',
    colNames    : [
      '-',
      'Aliquota ISSQN',
      'Total Serviços',
      'Total ISS'
    ],
    colModel    : [
      {name:'id_importacao_desif', hidden:true, sortable:false},
      {name:'aliq_issqn', width:20, sortable:false,
        formatter: function(cellvalue, options, rowObject) {
          return ' ' + rowObject['aliq_issqn'] + '%';
        }
      },
      {name:'total_receita', width:20, sortable:false},
      {name:'total_iss', width:20, sortable:false}
    ],
    loadComplete   : function(data) {

      if (data.error) {
        bootbox.alert(data.error);
      }
    }
  });
});