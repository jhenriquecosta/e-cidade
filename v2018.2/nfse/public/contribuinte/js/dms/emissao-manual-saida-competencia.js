$(function() {
  $elmForm = $('#form_competencia');
  $elmMes  = $('#mes_competencia');
  $elmAno  = $('#ano_competencia');
  
  $elmForm.find('input[type=submit]').click(function(e) {
    location.href = $elmForm.attr('action') + '/mes/' + $elmMes.val() + '/ano/' + $elmAno.val();
    e.preventDefault();
  });
});
