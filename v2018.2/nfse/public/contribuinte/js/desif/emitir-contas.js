$(function() {

  var $oBtnConsultar      = $("#btn_competencia");
  var $oBtnSalvar         = $("#btn_salvar");
  var $oForm              = $("#form_competencia");
  var $oSelectCompetencia = $("#competencia");
  var $aFieldSelecteds    = [];

  //Desabilita o botão caso não haja contas a serem emitidas
  if ($oSelectCompetencia.val() == undefined) {
    $oBtnSalvar.attr("disabled", "disabled");
  }

  /**
   * Cria e adiciona a grid no content da view
   */
  var $oJqGrid = $().DBJqGrid({
    url         : '/contribuinte/desif/listar-contas-emissao',
    sortname    : 'e.id',
    sortorder   : 'asc',
    postData    : { form:$oForm.closest('form').serializeObject() },
    colNames    : [
      '-',
      '<input type="checkbox" id="selectallCB" name="selectallCB"/>',
      'Conta',
      'Descrição',
    ],
    colModel    : [
      {name:'id', hidden:true, sortable:false},
      {name:'isEmitida', sortable: false, align:'center', width: 15 ,
        editable:true, edittype:'checkbox', editoptions: { value:'true:false'},
        formatter: 'checkbox', formatoptions: {disabled : false},
        cellattr: function() {
          return "class='cbEmpActive'";
        }
      },
      {name:'conta', width:25, sortable:false},
      {name:'descricao_conta', align:'left', width:180, sortable:false}
    ]
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
   * Retorna o ID das contas selecionadas
   *
   * @returns {Array}
   */
  var getContasSelecionadas = function() {

    $aFieldSelecteds = [];
    var $aIds = $oJqGrid.jqGrid('getDataIDs');

    if ($aIds.length > 0) {

      for (var i=0, il=$aIds.length; i < il; i++) {

        var checkbox =  $oJqGrid.jqGrid('getCell', $aIds[i], 'isEmitida');
        if(checkbox=='true') {

          var name = $oJqGrid.jqGrid('getCell', $aIds[i], 'id');
          $aFieldSelecteds.push(name);
        }
      }
    }
    return $aFieldSelecteds;
  }

  /**
   * Seleciona todas as contas obrigatórias
   */
  $("#selectallCB").click(function (e) {

    var isSelectAllTrue = $(this).is(":checked");
    e = e||event;/* get IE event ( not passed ) */
    e.stopPropagation? e.stopPropagation() : e.cancelBubble = true;

    var td = $('.cbEmpActive');
    for (var i=0;i<td.length; i++) {
      var checkbox = $('input[type="checkbox"]', $( td[i]).closest('td')).get(0);
      var checked = checkbox.checked;
      checkbox.checked = isSelectAllTrue;
    }

    $('.case').attr('checked', this.checked);
  });

  /**
   * Efetua a consulta
   */
  $oBtnConsultar.click(function(){
    atualizarGrid();
  });

  /**
   * Atualiza as contas obrigatórias
   */
  $oBtnSalvar.click(function() {

    var $oThis                   = $(this);
    var $sTxtElm                 = $(this).html();
    var $aContasSelecionadas     = getContasSelecionadas();
    var $aParametros             = $oForm.closest('form').serializeObject();
    $aParametros['selecionados'] = $aContasSelecionadas;
    $aParametros['contasPagina'] = $oJqGrid.jqGrid('getDataIDs');

    $.ajax({
      type       : 'POST',
      url        : '/contribuinte/desif/salvar-emissao',
      data       : $aParametros,
      beforeSend : function () { $oThis.html('Aguarde...').attr('disabled', true); },
      complete   : function () { $oThis.html($sTxtElm).attr('disabled', false); },
      success    : function(data) {
        if (data.status) {

          bootbox.alert(data.success, function() {
            atualizarGrid();
          });
        } else if (data.error) {

          var errors = 'Erros encontrados! ';

          $.each(data.error, function(i) {
            errors = errors + data.error[i]+ '\n';
          });
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      }
    });
  });
});