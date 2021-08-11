$(function() {
  var $oDmsLista       = $('#dms_lista');
  var sMensagemAguarde = $oDmsLista.attr('data-loading');
  var sUrlListaNotas   = $oDmsLista.attr('data-url');
  
  // Atualiza a lista de notas do Dms
  $oDmsLista.html('<div class="alert alert-info">' + sMensagemAguarde + '</div>');
  $oDmsLista.load(sUrlListaNotas);
});