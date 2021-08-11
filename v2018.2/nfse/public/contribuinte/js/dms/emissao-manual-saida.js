$(function() {
  var $oFieldset = $('fieldset');
  var $oTipoDocumento = $('#tipo_documento');
  var $oTipoDocumentoDescricao = $('#tipo_documento_descricao');
  var $oNaturezaOperacao = $('#natureza_operacao');
  var $oNumeroNota = $('#s_nota');
  var $oNumeroNotaSerie = $('#s_nota_serie');
  var $oDataNota = $('#s_nota_data');
  var $oIdDmsNota = $('#id');
  var $elmsCalculoDms = $('#s_imposto_retido, #natureza_operacao, #s_valor_bruto, #s_valor_deducao, #s_vl_condicionado, #s_vl_desc_incondicionado, #s_aliquota');
  var $oServicoPrestado = $('#s_servico_prestado');
  var $oServicoCodigoCnae = $('#s_dados_cod_cnae');
  var $oAliquota = $('#s_aliquota');
  var $oValorLiquido = $('#s_valor_pagar');
  var $oCpfCnpj = $('#s_cpf_cnpj');
  var $oInscricaoMunicipal = $('#s_inscricao_municipal');
  var $oRazaoSocial = $('#s_razao_social');
  var $oImpostoRetido = $('#s_imposto_retido');
  var $oIdDms = $('#id_dms');
  var $oMesCompetencia = $('#mes_comp');
  var $oAnoCompetencia = $('#ano_comp');
  var $oDmsListaNotas = $('#dms_lista_notas');
  var $oBtnFecharDms = $('#btn_fechar_dms');
  var $oBtnExcluirNota = $('.btn_excluir');
  var $oBtnLancarServico = $('#btn_lancar_servico');
  var $oBtnCadastrarTomador = $('#s_btn_cadastro_tomador');

  var sFildsets  = '#fieldset-dados_declarante, #fieldset-dados_tomador, #fieldset-dados_servico, dms_lista_notas,';
  		sFildsets += 'sFildsets';
  
  var $oFieldsets = $(sFildsets);
  
  // Verifica se é um prestador eventual
  var $lIsPrestadorEventual = $oTipoDocumentoDescricao.length;

  // Links
  var sUrlCalculaValoresDms = '/contribuinte/dms/emissao-manual-calcula-valores-dms';
  var sUrlVerificaDocumento = '/contribuinte/dms/emissao-manual-saida-verificar-documento';

  // Altera a verificação se for prestador eventual
  if ($lIsPrestadorEventual) {
    sUrlVerificaDocumento = '/contribuinte/dms/emissao-manual-saida-verificar-documento-prestador-eventual';
  }

  // Calendario (validando o intervalo de datas permitidas conforme competencia
  var currentTime = new Date();
  var mes = $oMesCompetencia.val() ? $oMesCompetencia.val() : currentTime.getMonth() + 0;
  var ano = $oAnoCompetencia.val() ? $oAnoCompetencia.val() : currentTime.getFullYear() + 1;
  var minDate = new Date(ano, mes - 1, +1);
  var maxDate = new Date(ano, mes, 0);

  $oDataNota.setMask('date').datepicker({
    minDate: minDate,
    maxDate: maxDate
  });

  // Verifica se o contribuinte é optante pelo simples e habilita o campo com alíquotas do simples nacional
  $oDataNota.change(function() {
    var sValorAliquota = $oAliquota.val();
    var sDataNota      = $(this).val();

    // Campo padrão (preenchido conforme serviço)
    $oAliquota.closest('div').html(
      '<input type="text" name="s_aliquota" id="s_aliquota" value="" class="span1 mask-porcentagem" ' +
        'readonly="readonly" style="text-align:right">' +
        '<span class="add-on">%</span></div>'
    );
    $oAliquota = $('#s_aliquota');
    $oAliquota.val(sValorAliquota);

    // Se informada a data, verifica via webservice se o contribuinte é optante pelo simples
    if (sDataNota.length == 10) {

      $.ajax({
        dataType: 'json',
        url     : $oDataNota.attr('data-url'),
        data    : { 'data' : sDataNota },
        error   : function(xhr){
        	$().bloqueiaEmissao(xhr, $oFieldsets);
        },     
        success : function(data) {

          // Mostra select com opções de aliquota
          if (data.status) {

            $oAliquota.closest('div').html(
              '<select name="s_aliquota" id="s_aliquota" class="span1">' +
                '<option value=""></option>' +
                '<option value="0,00">0</option>' +
                '<option value="2,00">2</option>' +
                '<option value="2,79">2,79</option>' +
                '<option value="3,50">3,5</option>' +
                '<option value="3,84">3,84</option>' +
                '<option value="3,87">3,87</option>' +
                '<option value="4,23">4,23</option>' +
                '<option value="4,26">4,26</option>' +
                '<option value="4,31">4,31</option>' +
                '<option value="4,61">4,61</option>' +
                '<option value="4,65">4,65</option>' +
                '<option value="5,00">5</option>' +
                '</select>' +
                '<span class="add-on">%</span>');

            $oAliquota = $('#s_aliquota');
            $oAliquota.val(sValorAliquota);
          }
        }
      });
    }

    // Recalcula os valores
    $oServicoPrestado.change();
    $oNaturezaOperacao.change();

    // Readiciona as máscaras no campo
    $().addMascarasCampos();
  });
  $oDataNota.change();

  // Recalcula os valores quando alterada a aliquota
  $oAliquota.live('change', function() {

    // Verifica somente quando conter valores pré-definidos (select)
    if ($(this).is('select') || $oNaturezaOperacao.val() != '1') {
      $oServicoPrestado.change();
    }
  });

  // Objeto para listar as notas do DMS
  var DmsListaNotasHtml = function(id_dms) {
    this.target = $oDmsListaNotas;
    this.url = $oDmsListaNotas.data('url') + '/id_dms/' + id_dms;
    this.getHtml = function() {
      this.target.loadHtml({ 'url': this.url }, function() {
        var bNotasAtivas = $('.btn_excluir').length <= 0;
        $oBtnFecharDms.attr('disabled', bNotasAtivas);
      });
    };
    this.getHtml(); // Construtor
  };

  // Minimiza Conteudo do Fieldset
  $oFieldset.find('legend').click(function() {
    $(this).parent('').children('').toggle();
  });

  // Ajuste Layout Twitter Bootstrap
  $oBtnFecharDms.closest('div.span1, div.span2, div.span3, div.span4').css({'margin-left': '190px', 'width': 'auto'});
  $oBtnFecharDms.parent('div.controls').css({'margin-left': '0'});

  // Habilita a retencao se preenchido o CPF/CNPJ
  $oCpfCnpj.keyup(function() {
    var sValor = $(this).val();

    if (sValor.length >= 18) {
      $oImpostoRetido.attr('disabled', false);
    } else {

      $oImpostoRetido.attr('disabled', true);
      $oImpostoRetido.attr('checked', false);
    }
  });
  $oCpfCnpj.keyup();

  // Dados do CGM
  $oCpfCnpj.blur(function(e) {
    var $oThis = $(this);
    var sCnpj = $(this).val();
    sCnpj = sCnpj.replace(/[^\d]+/g, '');

    $oBtnCadastrarTomador.addClass('hidden');

    if (sCnpj.length >= 11) {

      $.ajax({
        dataType  : 'json',
        url       : $oThis.data('url'),
        data      : { 'term': sCnpj },
        error     : function(xhr) {
        	$().bloqueiaEmissao(xhr, $oFieldsets);
        },
        success   : function(data) {

          $oInscricaoMunicipal.val('');
          $oRazaoSocial.val('');

          if ($oImpostoRetido.attr('checked')) {
            $oBtnCadastrarTomador.removeClass('hidden');
          }

          if (data) {

            if (!data.inscricao) {
              data = data[0];
            }

            $oInscricaoMunicipal.val(data.inscricao);
            $oRazaoSocial.val(data.nome);
            $oBtnCadastrarTomador.addClass('hidden');
          }
        }
      });
    }

    $oCpfCnpj.keyup();

    e.preventDefault();
    return false;
  });

  // Flag de Imposto Retido
  $oImpostoRetido.change(function() {
    // Verifica as regras da natureza da operação
    $oNaturezaOperacao.change();

    $oCpfCnpj.blur();
  });

  // Lanca Servico
  $oBtnLancarServico.click(function(e) {
    var $oThis = $(this);
    var $oForm = $(this).closest('form');
    var $oMessage = $('.ajax-message');
    var $oTarget = $('#dms_erros');
    var txtElm = $(this).val();

    // Remove as mensagens de erro
    $oMessage.remove();

    $.ajax({
      dataType  : 'json',
      url       : $oForm.attr('action'),
      data      : $oForm.serialize(),
      error   : function(xhr){
      	$().bloqueiaEmissao(xhr, $oFieldsets);
      },
      success   : function(data) {

        $oForm.find('.control-group').removeClass('error'); // Remove as classes de erro

        if (data && data.status && data.success) {

          $oIdDms.val(data.id_dms);
          $oBtnFecharDms.attr('disabled', false).removeClass('disabled');

          if (data.url) {
            bootbox.alert(data.success, function() {
              location.href = data.url;
            });
          } else {

            $oForm.formReset();
            $oCpfCnpj.val('');

            bootbox.alert(data.success, function() {
              DmsListaNotasHtml($oIdDms.val()); // Recarrega notas
            });

            $oDataNota.change();
            $oTipoDocumento.focus();
          }

        } else if (data && data.error) {

          var errors = '';

          $.each(data.error, function(i) {
            errors = errors + data.error[i] + '\n';
          });

          if (data.fields != undefined) {
            $.each(data.fields, function(i) {
              $('#' + data.fields[i]).closest('.control-group').addClass('error');
            });
          }

          var sMessage = '<div class="alert alert-error ajax-message"> ' +
            '  <button type="button" class="close" data-dismiss="alert">×</button>' + errors +
            '</div>';

          $oTarget.before(sMessage);
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      }
    });

    e.preventDefault();
    return false;
  });

  // Excluir Nota da DMS
  $oBtnExcluirNota.live('click', function(e) {
    var $oThis = $(this);

    bootbox.confirm('Confirma a exclusão?', function(bResult) {
      if (bResult) {
        $.ajax({
          dataType  : 'json',
          url       : $oThis.attr('href'),
          error     : function(xhr) {
          	$().bloqueiaEmissao(xhr, $oFieldsets);
          },
          success   : function(data) {
            if (data.status && data.success) {
              bootbox.alert(data.success, function() {
                DmsListaNotasHtml($oIdDms.val()); // Recarrega notas
              });
            } else if (data.error) {
              bootbox.alert(data.error);
            } else {
              bootbox.alert('Ocorreu um erro desconhecido!');
            }
          }
        });
      }
    });

    e.preventDefault();
    return false;
  });

  // Fechar DMS
  $oBtnFecharDms.click(function(e) {
    var $oThis = $(this);

    $.ajax({
      dataType  : 'json',
      url       : $oThis.data('url') + $oIdDms.val(),
      error     : function(xhr) {
      	$().bloqueiaEmissao(xhr, $oFieldsets);
      },
      success   : function(data) {
        if (data.status && data.success && data.url) {
          bootbox.alert(data.success, function() {
            location.href = data.url;
          });
        } else if (data.error) {
          bootbox.alert(data.error);
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      }
    });

    e.preventDefault();
    return false;
  });

  // Libera o campo de aliquota para tributação fora do municipio
  $oNaturezaOperacao.bind('change', function() {

    var $oFilds = $('#fieldset-dados_declarante, #fieldset-dados_tomador, #fieldset-dados_servico');

    $oFilds.find('input').attr('disabled', false);
    $oFilds.find('select').attr('disabled', false);
    $oFilds.find('textarea').attr('disabled', false);
    $oFilds.find('button').attr('disabled', false);
    $oBtnLancarServico.attr('disabled', false);

    // Tributado dentro do municipio bloqueia a aliquota
    if ($(this).val() == '1' && !$lIsPrestadorEventual) {

      if ($oAliquota.is('input')) {
        $oAliquota.attr('readonly', 'readonly');
      }
    } else if ($(this).val() == '2') {
    	$oServicoPrestado.attr('readonly', false);
    } else {

      $oFilds.find('input').attr('disabled', true);
      $oFilds.find('select').attr('disabled', true);
      $oFilds.find('textarea').attr('disabled', true);
      $oFilds.find('button').attr('disabled', true);
      $oBtnLancarServico.attr('disabled', true);
    }

    if (!$lIsPrestadorEventual) {
      $oServicoPrestado.trigger('change');
    }

    $(this).attr('disabled', false);
  });

  $oNaturezaOperacao.change();

  // Calcula a aliquota
  $oServicoPrestado.change(function() {
    var $oThis = $(this);

    // Apenas dentro do municipio (serviços fora do município e prestadores eventuais informam a alíquota manualmente)
    if ($oNaturezaOperacao.val() == 1 && !$lIsPrestadorEventual) {

      $.ajax({
        dataType  : 'json',
        url       : $oThis.data('url') + 'id_servico/' + $oThis.val(),
        error     : function(xhr) {
        	$().bloqueiaEmissao(xhr, $oFieldsets);
        },
        success   : function(data) {
        	
        	if (data.erro) {
        		$().bloqueiaEmissao(data, $oFieldsets);
        	} else {

	          // Altera a aliquota somente quando for campo de texto e não um select (optante simples)
	          if ($oAliquota.is('input')) {
	
	            if (data.aliq) {
	              $oAliquota.val(data.aliq);
	            } else {
	              $oAliquota.val(0);
	            }
	          }
	
	          if (data.estrut_cnae) {
	            $oServicoCodigoCnae.val(data.estrut_cnae);
	          }
	
	          $oValorLiquido.calculaValoresDms({ 'url': sUrlCalculaValoresDms },
	            function(data) {
	              if (data) {
	                $.each(data, function(elm, valor) {
	                  $('#' + elm).val(valor);
	                });
	              }
	            }
	          );
        	}
        }
      });
    } else {

      $oValorLiquido.calculaValoresDms({ 'url': sUrlCalculaValoresDms },
        function(data) {
          if (data) {
            $.each(data, function(elm, valor) {
              $('#' + elm).val(valor);
            });
          }
        }
      );
    }
  });
  $oServicoPrestado.change();

  // Carrega lista de notas do DMS
  DmsListaNotasHtml($oIdDms.val());

  // Calcula Valores Dms
  $elmsCalculoDms.bind('change blur', function() {

    $oValorLiquido.calculaValoresDms({ 'url': sUrlCalculaValoresDms },
      function(data) {
        if (data) {
          $.each(data, function(elm, valor) {
            $('#' + elm).val(valor);
          });
        }
      }
    );
  });
  $oServicoPrestado.change();

  // Verifica se ja existe uma nota com o numero e se tem AIDOF [Json]
  $('#tipo_documento, #s_nota').bind('focusout', function() {

    // Ignora verificação se for prestador eventual
    if ($lIsPrestadorEventual) {
      return;
    }

    var $oTarget = $('#fieldset-dados_tomador');
    var sUrl = sUrlVerificaDocumento;
    var $oMessage = $('.ajax-message-verifica-documento');

    $oMessage.remove();

    if ($oTipoDocumento.val()) {

      sUrl = sUrl + '/tipo_documento/' + $oTipoDocumento.val();

      if ($oNumeroNota.val()) {
        sUrl = sUrl + '/s_nota/' + $oNumeroNota.val();
      }

      if ($oIdDmsNota.val()) {
        sUrl = sUrl + '/id/' + $oIdDmsNota.val();
      }

      $.ajax({
        dataType: 'json',
        url     : sUrl,
        async   : false,
        error   : function(xhr){
        	$().bloqueiaEmissao(xhr, $oFieldsets);
        },
        success : function(data) {

        	if (data && data.error) {

            var errors = '';

            $.each(data.error, function(i) {
              errors = errors + data.error[i] + '\n';
            });

            var sMessage = '<div class="alert alert-error ajax-message-verifica-documento"> ' +
              '  <button type="button" class="close" data-dismiss="alert">×</button>' + errors +
              '</div>';
            $oTarget.before(sMessage);
          } else if (data && data.erro) {
        		$().bloqueiaEmissao(data, $oFieldsets);
        	}
        }
      });
    }
  });

  /* 
   * Eventos ativados apenas para contribuintes eventuais
   */
  if ($lIsPrestadorEventual) {

    // Ajuste plugin "combobox" para carregar o valor do combobox no input hidden gerado pelo plugin
    $oServicoPrestado.ready(function() {
      var $oServicoPrestadoHidden = $('input[name=' + $oServicoPrestado.attr('id') + ']');
      $oServicoPrestadoHidden.val($oServicoPrestado.val());
    }).combobox();

    // Verifica se ja existe uma nota com o numero
    $('#tipo_documento_descricao, #s_nota, #s_serie_nota').bind('focusout', function() {
      var $oTarget = $('#fieldset-dados_tomador');
      var sUrl = sUrlVerificaDocumento;
      var $oMessage = $('.ajax-message-verifica-documento');

      $oMessage.remove();

      if ($oTipoDocumentoDescricao.val()) {

        sUrl = sUrl + '/tipo_documento_descricao/' + $oTipoDocumentoDescricao.val();

        if ($oNumeroNota.val()) {
          sUrl = sUrl + '/s_nota/' + $oNumeroNota.val();
        }

        if ($oNumeroNotaSerie.val()) {
          sUrl = sUrl + '/s_nota_serie/' + $oNumeroNotaSerie.val();
        }

        if ($oIdDmsNota.val()) {
          sUrl = sUrl + '/id/' + $oIdDmsNota.val();
        }

        $.ajax({
          dataType: 'json',
          url     : sUrl,
          async   : false,
          error   : function(xhr){
          	$().bloqueiaEmissao(xhr, $oFieldsets);
          },
          success : function(data) {
            if (data && data.error) {

              var errors = '';

              $.each(data.error, function(i) {
                errors = errors + data.error[i] + '\n';
              });

              var sMessage = '<div class="alert alert-error ajax-message-verifica-documento"> ' +
                '  <button type="button" class="close" data-dismiss="alert">×</button>' + errors +
                '</div>';
              $oTarget.before(sMessage);
            }
          }
        });
      }
    });
  }
});