$(function() {
  var $oEstado = $('#estado');
  var $oCodigoBairro = $('#cod_bairro');
  var $oTextoBairro = $('#bairro');
  var $oCodigoEndereco = $('#cod_endereco');
  var $oTextoEndereco = $('#endereco');
  var $oCidade = $('#cidade');
  var $oPerfil = $('#id_perfil');
  var $oCnpjCpf = $('#cnpjcpf');
  var $oForm = $('#formCadastroPessoa');
  var $oSalvar = $('#cadastrar');
  var $oVoltarLogin = $('#voltar_login');
  var $oNumeroEnd = $('#numero');

  /**
   * Submit do Form
   */
  $oSalvar.click(function() {
    var text = $(this).val();

    // Bloqueia os campos no submit
    $oForm.find('input').attr('readonly', true);
    $oForm.find('select').attr('readonly', true).addClass('readonly');
    $oForm.find('textarea').attr('readonly', true);
    $oSalvar.val('Aguarde...').attr('disabled', true);
    $oVoltarLogin.attr('disabled', true);

    // Executa o envio do formulario
    $oForm.submitForm({
      'eMessageContainer': $('#erros'),
      'completeCallback' : function() {

        // Desbloqueia os campos no submit
        $oForm.find('input').attr('readonly', false);
        $oForm.find('select').attr('readonly', false).removeClass('readonly');
        $oForm.find('textarea').attr('readonly', false);
        $oSalvar.val(text).attr('disabled', false);
        $oVoltarLogin.attr('disabled', false);
      }
    });

    return false;
  });

  /**
   * Clique no botão voltar
   */
  $oVoltarLogin.click(function(e) {
    location.href = $(this).attr('url');
    e.preventDefault();
    return false;
  });

  /**
   * Troca de perfil, mostra apenas somente o CNPJ quando for Prestador
   */
  $oPerfil.change(function() {
    $oCnpjCpf.val('').focus();

    if ($(this).val() == 4) {
      $oCnpjCpf.parent('').parent().find('label').html('CPF / CNPJ:');
    } else {
      $oCnpjCpf.parent('').parent().find('label').html('CNPJ:');
    }
  });

  /**
   * Máscara para CNPJ/CPF
   */
  $oCnpjCpf.keyup(function() {
    var $this = $(this);
    var number = $this.val().replace(/\D/g, '');

    $this.unsetMask();

    if ($oPerfil.val() == 6) {
      $this.setMask('99.999.999/9999-99?9');
    } else {
      if (number.length > 11) {
        $this.setMask('99.999.999/9999-99?9');
      } else {
        $this.setMask('999.999.999-999?9');
      }
    }
  }).trigger('keyup');

  // Esconde os combos de bairro e endereco
  $oCodigoBairro.closest('.control-group').parent().addClass('hide');
  $oCodigoEndereco.closest('.control-group').parent().addClass('hide');

  /**
   * Troca de estado (UF)
   */
  $oEstado.change(function() {
    var sHtml = '';

    $(this).ajaxSelect({
      'done': function(data) {

        if (data) {

          $.each(data, function(indice, valor) {
            if (valor) {
              sHtml = sHtml + '<option value="' + indice + '">' + valor + '</option>\n';
            }
          });

          $oCidade.html(sHtml);
        }

        $oCidade.change();
      }
    });
  });

  /**
   * Troca de cidade
   *
   * @namespace data.mostra_campo_texto
   */
  $oCidade.change(function() {
    $oCodigoBairro.html('');
    $oCodigoEndereco.html('');

    $(this).ajaxSelect({
      'done': function(data) {

        if (data) {

          // Mostra o campos de texto
          if (data.mostra_campo_texto) {

            $oCodigoBairro.closest('.control-group').parent().addClass('hide');
            $oTextoBairro.val('').closest('.control-group').parent().removeClass('hide');
            $oCodigoEndereco.closest('.control-group').parent().addClass('hide');
            $oTextoEndereco.val('').closest('.control-group').parent().removeClass('hide');
          } else {

            $.each(data, function(indice, valor) {

              if (valor) {
                $oCodigoBairro.append('<option value="' + indice + '">' + valor + '</option>');
              }
            });

            $oCodigoBairro.closest('.control-group').parent().removeClass('hide');
            $oTextoBairro.closest('.control-group').parent().addClass('hide');

            // Mostra Bairros se a cidade for igual da configuracao (combo ou campo texto)
            $oCodigoBairro.ajaxSelect({
              'done': function(data) {

                if (data) {

                  $.each(data, function(indice, valor) {

                    if (valor) {
                      $oCodigoEndereco.append('<option value="' + indice + '">' + valor + '</option>');
                    }
                  });

                  $oCodigoEndereco.closest('.control-group').parent().removeClass('hide');
                  $oTextoEndereco.closest('.control-group').parent().addClass('hide');
                }
              }
            });

            // Seta o valor do input com o mesmo texto do select
            $oCodigoBairro.change();
            $oCodigoEndereco.change();
          }
        }
      }
    });
  });

  /**
   * Troca de bairro
   */
  $oCodigoBairro.change(function() {
    $oTextoBairro.val($(this).find('option:selected').html());
  });

  /**
   * Troca de Endereco
   */
  $oCodigoEndereco.change(function() {
    $oTextoEndereco.val($(this).find('option:selected').html());
  });

  /**
   * Válida número
   */
  $oNumeroEnd.keyup(function() {
    $(this).val().replace(/\D/g, '');
  }).trigger('keyup');
});