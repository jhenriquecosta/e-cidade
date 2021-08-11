$(function() {

  var $elmCgm            = $('input#cgm');
  var $elmCnpj           = $('input#cnpj');
  var $elmNome           = $('input#nome');
  var $elmContador       = $('select#contador');
  var $elmHelpBlock      = $('p.help-block');
  var $elmLogin          = $('input#login');
  var $elmTipo           = $('select#tipo');
  var $elmEmail          = $('input#email');
  var $elmTelefone       = $('input#telefone');
  var $elmHdnInscricao   = $('input#insc_municipal');

  $elmCnpj.closest('.control-group').hide();
  $elmCnpj.buscador({
    statusInput : 'p.help-block',
    success     : function(data) {

      $elmHelpBlock.html(data.razao_social);
      $elmCgm.val(data.cgm);
      $elmLogin.val(data.login);
      $elmNome.val(data.nome);
      $elmEmail.val(data.email);
      $elmTelefone.val(data.telefone);

      if ($('#content-insc-municipal')) {
        $('#content-insc-municipal').remove();
      }

      if (typeof data.inscricoes !== "undefined") {

        $('#insc_municipal')
          .after($('<div></div>')
            .attr({'id':"content-insc-municipal"})
            .addClass("control-group")
            .append($('<label>Inscrição Municipal:</label>')
              .attr({'for':"insc_municipal"})
              .addClass("control-label optional")
              .after($('<div></div>')
                .addClass('controls')
                .append($('<select></select>')
                  .attr({'id':'sel_insc_municipal'})
                )
              )
            )
          ).html();

        var $elmInscMunicipal = $('select#sel_insc_municipal').change(function(e) {
          $elmHdnInscricao.val($(this).val());
        });

        $elmInscMunicipal.closest('.control-group').show();
        $.each(data.inscricoes, function(i, t) {
            $elmInscMunicipal.append($("<option />").val(i).text(t));
        });
      }
    }
  });
  
  $elmContador.closest('.control-group').hide();
  $elmContador.change(function() {
    $elmLogin.val($(this).val());
    $elmCnpj.val($(this).val());
  });  
  
  $elmTipo.change(function() {
    $elmLogin.val('');
    $elmCnpj.val('');
    
    if ($(this).val() == 2) { /* se for tipo contador busca a lista de contadores e mostra no select */
      
      $elmCnpj.closest('.control-group').hide();
      $elmContador.closest('.control-group').show();
      $elmContador.change();
      $elmLogin.attr('readonly',true);
    } else if ($(this).val() == 1) { //se for do tipo contribuinte, mostra input para busca por CNPJ
      
      $elmContador.closest('.control-group').hide();
      $elmCnpj.closest('.control-group').show();
      $elmLogin.attr('readonly',true);           
    } else {
      
      $elmContador.closest('.control-group').hide();
      $elmCnpj.closest('.control-group').hide();
      $elmLogin.attr('readonly',false);
    }
  });

  $elmTipo.change();
});