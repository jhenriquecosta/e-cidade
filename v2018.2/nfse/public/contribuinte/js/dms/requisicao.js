$(function() {
  $('.tooltip-modal').popover({
    placement : 'left',
    trigger   : 'hover',
    title     : 'Observações',
    html      : true
  });
  
  $(document).on('click', '.cancelar-requisicao', function(e) {
    e.preventDefault();
    
    var $elm = $(this); 
    
    bootbox.confirm('Deseja realmente cancelar a requisição?', function(result) {
      if (result) {
        
        $.ajax({
          dataType    : 'json',
          url         : $elm.attr('href'),
          forceSync   : true,
          beforeSend  : function() {},
          error       : function(xhr) {
            bootbox.alert('Ocorreu um erro desconhecido!\nreadyState: ' +xhr.readyState+ '\nstatus: ' +xhr.status);
          },
          success     : function(data) {
            if (data.status) {
              
              bootbox.alert(data.success, function() {
                location.href = '/contribuinte/dms/requisicao';
              });
            } else if (data.error) {
              
              var erros = '';
              
              $.each(data.error, function(i) {
                erros = data.error[i]+ '\n';  
              });
              
              bootbox.alert(erros);  
            } else {
              bootbox.alert('Ocorreu um erro desconhecido!');
            }
          }
        });
      }
    }); 
  
    return false;
  });
  
  /**
   * @see /js/lib/jquery.extends.DBSeller.js
   */
  $('input#submit').click(function(e) {
    $(this).submitForm();
    e.preventDefault();
    return false;
  });  
});