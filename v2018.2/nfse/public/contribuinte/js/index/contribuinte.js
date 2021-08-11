$(function() {
  var $oCmbContribuinte = $('#cb_contribuinte');
  var $oUrlContribuinte = $("#url_contribuinte");
  
  $oCmbContribuinte.change(function(e) {
    $oUrlContribuinte.attr('href', $(this).val());
  }).combobox();
});
