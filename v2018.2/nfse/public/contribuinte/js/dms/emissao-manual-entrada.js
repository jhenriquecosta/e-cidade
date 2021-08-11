$(function() {
  var $oFieldset = $('fieldset');
  var $oTipoDocumento = $('#tipo_documento');
  var $oNumeroNota = $('#s_nota');
  var $oDataNota = $('#s_nota_data');
  var $oIdDmsNota = $('#id');
  var $elmsCalculoDms = $('#s_imposto_retido, #s_valor_bruto, #s_valor_deducao, #s_vl_condicionado, #s_vl_desc_incondicionado, #s_aliquota');
  var $oValorLiquido = $('#s_valor_pagar');
  var $oCpfCnpj = $('#s_cpf_cnpj');
  var $oInscricaoMunicipal = $('#s_inscricao_municipal');
  var $oRazaoSocial = $('#s_razao_social');
  var $oImpostoRetido = $('#s_imposto_retido');
  var $oIdDms = $('#id_dms');
  var $oMesCompetencia = $('#mes_comp');
  var $oAnoCompetencia = $('#ano_comp');
  var $oDmsListaNotas = $('#dms_lista_notas');
  var $elmsValidaExisteNota = $('#tipo_documento, #s_nota, #s_cpf_cnpj');
  var $oBtnFecharDms = $('#btn_fechar_dms');
  var $oBtnExcluirNota = $('.btn_excluir');
  var $oBtnLancarServico = $('#btn_lancar_servico');
  var $oBtnCadastrarTomador = $('#s_btn_cadastro_tomador');
  var $oFormulario = $oBtnLancarServico.closest('form');
  var $oNaturezaOperacao = $('#natureza_operacao');

  var sFildsets  = '#fieldset-dados_declarante, #fieldset-dados_tomador, #fieldset-dados_servico, #dms_lista_notas,';
	sFildsets     += '#fieldset-fechar-dms';

	var $oFieldsets = $(sFildsets);

  // Links
  var sUrlCalculaValoresDms = $oFormulario.attr('sUrlCalculaValoresDms');
  var sUrlVerificaDocumento = $oFormulario.attr('sUrlVerificaDocumento');

  // Calendario (validando o intervalo de datas permitidas conforme competencia
  var currentTime = new Date();
  var mes = $oMesCompetencia.val() ? $oMesCompetencia.val() : currentTime.getMonth() + 0;
  var ano = $oAnoCompetencia.val() ? $oAnoCompetencia.val() : currentTime.getFullYear() + 1;
  var minDate = new Date(ano, mes - 1, +1);
  var maxDate = new Date(ano, mes, 0);

  /**
   * Máscara nas datas
   */
  $oDataNota.setMask('date').datepicker({
    minDate: minDate,
    maxDate: maxDate
  });

  /**
   * Objeto para listar as notas do DMS
   *
   * @param id_dms
   * @constructor
   */
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

  /**
   * Minimiza Conteudo do Fieldset
   */
  $oFieldset.find('legend').click(function() {
    $(this).parent('').children('').toggle();
  });

  /**
   * Ajuste Layout Twitter Bootstrap
   */
  $oBtnFecharDms.closest('div.span1, div.span2, div.span3, div.span4').css({'margin-left': '190px', 'width': 'auto'});
  $oBtnFecharDms.parent('div.controls').css({'margin-left': '0'});

  /**
   * Habilita a retencao se preenchido o CNPJ
   */
  $oCpfCnpj.keyup(function() {
    var sValor = $(this).val();

    // Se for CPF, obrigado o Tomador a reter o ISS (Exeção para RPA - Médicos)
    if (sValor.length < 18) {
      $oImpostoRetido.attr('readonly', true).attr('checked', true);
    } else {
      $oImpostoRetido.attr('readonly', false);
    }
  });
  $oCpfCnpj.keyup();

  /**
   * Dados do CGM
   *
   * @namespace data.inscricao
   * @namespace data.nome
   */
  $oCpfCnpj.blur(function(e) {
    var $oThis = $(this);
    var sCnpj = $(this).val();
    sCnpj = $().returnNumbers(sCnpj);

    $oBtnCadastrarTomador.addClass('hidden');

    if (sCnpj.length >= 14) {

      $.ajax({
        dataType  : 'json',
        url       : $oThis.data('url'),
        data      : { 'term': sCnpj },
        error     : function(xhr, err) {
        	$().bloqueiaEmissao(xhr, $oFieldsets);
        },
        success   : function(data) {

          $oInscricaoMunicipal.val('');
          $oRazaoSocial.val('');

          if (data) {

            if (data.success == false) {

              $oCpfCnpj.val(null);
              bootbox.alert(data.message);

            } else {

              if (!data.inscricao) {
                data = data[0];
              }

              if ($oImpostoRetido.attr('checked')) {
                $oBtnCadastrarTomador.removeClass('hidden');
              }

              $oInscricaoMunicipal.val(data.inscricao);
              $oRazaoSocial.val(data.nome);
              $oBtnCadastrarTomador.addClass('hidden');

            }
          }
        }
      });
    }

    $oCpfCnpj.keyup();

    e.preventDefault();
    return false;
  });

  /**
   * Clique no imposto retido
   */
  $oImpostoRetido.click(function() {
    $oCpfCnpj.blur();
  });

  /**
   * Lança o serviço
   *
   * @namespace error.exception.information
   * @namespace data.id_dms
   * @namespace data.fields
   */
  $oBtnLancarServico.live('click', function(e) {
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
      error     : function(xhr) {
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
            $oNaturezaOperacao.change();

            bootbox.alert(data.success, function() {
              DmsListaNotasHtml($oIdDms.val()); // Recarrega notas
            });

            $oTipoDocumento.focus();
          }

        } else if (data && data.error) {

          var errors = '';

          $.each(data.error, function(i) {
            errors = errors + data.error[i] + '\n';
          });

          if (undefined != data.fields) {
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

  /**
   * Excluir Nota da DMS
   */
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

  /**
   * Fechar DMS
   */
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

  /**
   * Carrega lista de notas do DMS
   */
  DmsListaNotasHtml($oIdDms.val());

  /**
   * Calcula Valores Dms
   */
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

  /**
   * Verifica se ja existe uma nota com o numero e se tem AIDOF [Json]
   */
  $elmsValidaExisteNota.bind('focusout', function() {
    var $oTarget = $('#fieldset-dados_tomador');
    var sUrl = sUrlVerificaDocumento;
    var $oMessage = $('.ajax-message-verifica-documento');

    $oMessage.remove();

    if ($oTipoDocumento.val() && $oNumeroNota.val() && $oCpfCnpj.val()) {

      // Envia o tipo de documento + número da nota + cfp/cnpj do prestador do serviço
      sUrl += '/tipo_documento/' + $oTipoDocumento.val();
      sUrl += '/s_nota/' + $oNumeroNota.val();
      sUrl += '/s_cpf_cnpj/' + $().returnNumbers($oCpfCnpj.val());

      // Se for edição da nota, envia o ID para verificação
      if ($oIdDmsNota.val()) {
        sUrl = sUrl + '/id/' + $oIdDmsNota.val();
      }

      // Verifica o documento e retorna os erros, caso existam
      $.ajax({
        dataType: 'json',
        url     : sUrl,
        async   : false,
        error   : function(xhr) {
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

  $oNaturezaOperacao.change(function () {

  	var $oFilds = $('#fieldset-dados_declarante, #fieldset-dados_tomador, #fieldset-dados_servico');

    $oFilds.find('input').attr('disabled', false);
    $oFilds.find('select').attr('disabled', false);
    $oFilds.find('textarea').attr('disabled', false);
    $oFilds.find('button').attr('disabled', false);
    $oBtnLancarServico.attr('disabled', false);

    // Tributado dentro do municipio bloqueia a aliquota
    if ($(this).val() != '1' && $(this).val() != '2') {

      $oFilds.find('input').attr('disabled', true);
      $oFilds.find('select').attr('disabled', true);
      $oFilds.find('textarea').attr('disabled', true);
      $oFilds.find('button').attr('disabled', true);
      $oBtnLancarServico.attr('disabled', true);
    }

    $(this).attr('disabled', false);
    $('#s_valor_imposto').attr('readonly', true);
    $('#s_imposto_retido').attr('readonly', true);
    $('#s_base_calculo').attr('readonly', true);
    $('#s_valor_pagar').attr('readonly', true);
  });

  $oNaturezaOperacao.change();
});