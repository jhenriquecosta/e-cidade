$(function() {
	
	var $oDescricao    = $('#descricao');
	var $oBtnSalvar    = $('#btn_salvar');
	var $oModalOverlay = $('.modal-backdrop');
	
	$oBtnSalvar.click(function(){
		
		var $oForm      = $(this).closest("form");
		var sTextoBotao = $(this).val();
		
		$.ajax({
      dataType    : 'json',
      url         : $oForm.attr('action'),
      data        : $oForm.serialize(),
      beforeSend  : function() {
      	
        $oForm.find('.error').removeClass('error');
        $oBtnSalvar.html('Aguarde...').attr('disabled', true);
      },
      complete    : function() {
      	$oBtnSalvar.attr('disabled', false).html(sTextoBotao);
      },
      success     : function(data) {
      	
        if (data && data.success) {

          $oModalOverlay.css({ 'opacity': 0 });
          bootbox.alert(data.message);
        } else if (data && data.error) {

          var errors = '';

          $.each(data.error, function(i) {
            errors = errors + data.error[i]+ '\n';
          });

          if (data.fields != undefined) {
            $.each(data.fields, function(i) {
              $('#' +data.fields[i]).prev('label').addClass('error');
              $('#' +data.fields[i]).addClass('error').focus();
            });
          }
          
          bootbox.alert(errors);
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      },
      error       : function(xhr, err, thrownError) {
        
        if (xhr.responseText) {
          
          var error = $.parseJSON($.trim(xhr.responseText));
          bootbox.alert(error.message);
          
          if (error.exception) {
            console.log(error.exception);
          }
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!<br>readyState: ' +xhr.readyState+ '<br>status: ' +xhr.status);
        }
        
        settings.eThis.attr('disabled', false);
      }
		});
	});
});