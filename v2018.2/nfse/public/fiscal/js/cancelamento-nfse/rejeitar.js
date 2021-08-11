$(function() {

  var oForm          = $('form#CancelamentoRejeitar');
  var oJustificativa = $('textarea#justificativa_fiscal');
  var oBtnFechar     = $('button.input-medium.btn.btn-danger.fechar-modal');
  var oBtnConfirmar  = $('button#confirmar');
  var jQGrid         = $('#jqList');
  var modalForm      = $('#myModal');

  oBtnConfirmar.click(function() {

    if (oJustificativa.val() == '') {

      bootbox.alert('É necessário uma justificativa!');
      oJustificativa.focus();
      return false
    }

    $.ajax({
      type : 'POST',
      dataType : 'json',
      url : oForm.attr('action'),
      data: oForm.serialize(),
      beforeSend : function () {

        oForm.find('*').attr('readonly', true);
        oBtnFechar.attr('disabled', true);
        oBtnConfirmar.attr('disabled', true).html('Aguarde...');
      },
      success : function(data) {

        if (data && data.success) {
          bootbox.alert(data.success);
        } else if (data && data.error) {

          var errors = '';
          $.each(data.error, function(i) {
            errors = errors + data.error[i]+ '\n';
          });

          bootbox.alert(errors);
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }

        modalForm.modal('hide');
        modalForm.on('hidden.bs.modal', function() {
          atualizarGrid();
        });
      },
      error : function(xhr) {

        if (xhr.responseText) {

          var error = $.parseJSON($.trim(xhr.responseText));
          bootbox.alert(error.exception.information);

          if (error.exception) {
            s(error.exception);
          }
        } else {
          bootbox.alert('Ocorreu um erro ao processar!<br>readyState: ' +xhr.readyState+ '<br>status: ' + xhr.status);
        }
      }
    }).done(function() {

      oForm.find('*').attr('readonly', false);
      oBtnFechar.attr('disabled', true);
      oBtnConfirmar.attr('disabled', true).html('Aguarde...');
    });
  });

  /**
   * Atualiza os dados da grid
   */
  var atualizarGrid = function() {

    jQGrid.jqGrid("setGridParam", {
      datatype : "json"
    }).trigger("reloadGrid", [{current: true, page: jQGrid.getGridParam('page')}]);
  }
});