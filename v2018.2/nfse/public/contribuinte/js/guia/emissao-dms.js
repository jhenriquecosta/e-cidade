$(function() {
  var $oDmlLista      = $('#lista_dms');
  var $oBtnBuscar     = $('#btn_competencia');
  var $oGerarGuia     = $('.gerar-guia');
  
  /**
   * Carrega lista
   */
  $oBtnBuscar.click(function(e) {
    var $oForm = $oBtnBuscar.closest('form');
    var sUrl   = $oForm.attr('action') + '?' + $oForm.serialize();
    
    $oDmlLista.loadHtml({ 'url' : sUrl });
    
    e.preventDefault();
  });   
  $oBtnBuscar.click();
  
  /**
   * Abre a modal para geração da guia
   */
  $oGerarGuia.live('click', function(e) {
    var $oModal = $('#myModal');
    
    $oModal.load($(this).attr('href'));
    $oModal.modal('show');
    
    // Remove o click na parte de fora do modal (se setar via evento, ele retira o estilo)
    $oModal.on('shown', function() {
      var $oModalBackdrop = $('.modal-backdrop');      
      $oModalBackdrop.unbind('click');
    });
    
    e.preventDefault();
  });
});