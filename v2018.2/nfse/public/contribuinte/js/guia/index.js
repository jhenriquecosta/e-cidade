$(function() {
  var $oCheckBox    = $('input[type=checkbox]');
  var $oGuiaTomador = $('#guia-tomador');
  
  $oCheckBox.click(function() {
    if (!!$(this).attr('checked')) {
      $(this).parents('tr').addClass('info');
    } else {
      $(this).parents('tr').removeClass('info');
    }
  });
  
  $oGuiaTomador.click(function() {
    var aNotas  = [];
    var $oModal = $('#myModal');
    
    $(':checked').each(function(indice, valor) {
      aNotas.push($(valor).data('nota'));
    });
    
    $.ajax({
      url     : '/contribuinte/guia/tomador',
      data    : $(':checked').serialize(),
      type    : 'POST',
      success : function(response) {
        $oModal.html(response);
      }
    });
    
    $oModal.modal('toggle');
  });
});