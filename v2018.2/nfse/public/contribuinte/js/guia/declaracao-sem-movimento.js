$(function() {
  var $btnGerar   = $('#btn_gerar');
  var $btnBuscar  = $('#btn_pesquisar');
  var $elmRetorno = $("#retorno-ajax");
  
  /**
   * Gerar Declaracao sem Movimento
   * 
   * @see /js/lib/jquery.extends.DBSeller.js
   */
  $btnGerar.click(function(e) {
    $(this).submitForm();
    e.preventDefault();
    return false;
  });
  
  /**
   * Busca declaracoes sem movimento
   */
  $btnBuscar.click(function(e) {
    var $elmForm = $(this).closest('form');
    
    $.ajax({
      url         : $elmForm.attr('action'),
      data        : $elmForm.serialize(),
      dataType    : 'html',
      type        : 'post',
      beforeSend  : function()  {
        $(this).attr('disabled', true);
        $elmRetorno.html('<div class="alert alert-success">Processando...</div>');
      },
      complete    : function()  { 
        $(this).attr('disabled', false);
      },
      success     : function(data) {
        $elmRetorno.html(data);
      },
      error       : function(xhr, err) {
        $elmRetorno.html('<div class="alert alert-error">Ocorreu um erro processar</div>');
        $(this).attr('disabled', false);
      }
    });
    
    e.preventDefault();
    return false;
  });
  
  // Chama o evento click para listar os itens ao carregar a tela
  $btnBuscar.click();
});


