$(function() {

  var $oBtnConsultar   = $("#btn_consultar");
  var $oBtnSalvar      = $("#btn_salvar");
  var $oForm           = $("#formListarContas");
  var $aFieldSelecteds = [];

  /**
   * Cria e adiciona a grid no content da view
   */
  var $oJqGrid = $().DBJqGrid({
    url         : '/fiscal/conta-abrasf/listar-contas',
    sortname    : 'e.id',
    sortorder   : 'asc',
    postData    : { form:$oForm.closest('form').serializeObject() },
    colNames    : [
      '-','<input type="checkbox" id="selectallCB" name="selectallCB"/>',
      'Conta Abrasf',
      'Titulo Contábil',
      'Tributavel'
    ],
    colModel    : [
      {name:'id', hidden:true, sortable:false},
      {name: 'obrigatorio', sortable: false, align:'center', width: 15 ,
        editable:true, edittype:'checkbox', editoptions: { value:'true:false'},
        formatter: 'checkbox', formatoptions: {disabled : false},
        cellattr: function() {
          return "class='cbEmpActive'";
        }
      },
      {name:'conta_abrasf', width:25, sortable:false},
      {name:'titulo_contabil_desc', align:'left', width:180, sortable:false},
      {name:'tributavel', width:25, align:'center', sortable:false,
        formatter: function(cellvalue, options, rowObject) {
          return (rowObject['tributavel']) ? 'Sim' : 'Não';
        }
      }
    ]
  });

  /**
   * Atualiza os dados da grid
   */
  var atualizarGrid = function() {

    $oJqGrid.jqGrid("setGridParam", {
      datatype : "json",
      postData : { form:$oForm.closest('form').serializeObject() }
    }).trigger("reloadGrid", [{current: true, page: 1}]);
  }

  /**
   * Retorna o ID das contas selecionadas
   *
   * @returns {Array}
   */
  var getContasSelecionadas = function() {

    var $aIds = $oJqGrid.jqGrid('getDataIDs');
    if ($aIds.length > 0) {

      for (var i=0, il=$aIds.length; i < il; i++) {

        var checkbox =  $oJqGrid.jqGrid('getCell', $aIds[i], 'obrigatorio');
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

    var $oThis               = $(this);
    var $sTxtElm             = $(this).html();
    var $aContasSelecionadas = getContasSelecionadas();

    if ($aContasSelecionadas.length == 0) {
      bootbox.alert('Selecione pelo menos uma conta!');
    } else {

      $.ajax({
        type       : 'POST',
        url        : '/fiscal/conta-abrasf/salvar-contas',
        data       : { selecionados:$aContasSelecionadas },
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
    }
  });
});