$('.telefone').live('keypress', function(e) {
  var letra = e.which;

  // Pega somente numeros ou "(", ")" e "-"
  if ((letra >= 48 && letra <= 57 && $(this).val().length < 13) || letra == 40 || letra == 41 ||
       letra == 45 || letra == 8 || letra == 13 || letra == 113 || letra == 0)
    return true;
  return false;
});

$('.numerico, .mask-numero').live('keypress', function(e) {
  var letra = e.which;
  
  if ((letra >= 48 && letra <= 57) || letra == 0 ||
       letra == 8 || letra == 13 || letra == 113)
    return true;
  return false;
});

$(function() {
  // Adiciona mascaras nos campos do formulario, conforme classe do campo
  $().addMascarasCampos();
});
