$(function() {

  var iValIdContribuinte = $('#id_contribuinte option:selected').val();

  $('#id_contribuinte').combobox();

  $('input[name="id_contribuinte"]').val(iValIdContribuinte);
});
