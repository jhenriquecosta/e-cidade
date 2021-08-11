
$(document).ready(function() {
  
  $("button#nova, button#imprimir").click(function() {
    
    var url = $(this).attr('url');
    window.location.href = url;
  });
  
});

