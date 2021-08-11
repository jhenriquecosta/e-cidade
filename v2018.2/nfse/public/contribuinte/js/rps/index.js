/**
 * Executa ao apos carregar a pagina
 */
$(window).load(function() {
  var $oTomadorCpfCnpj = $('#t_cnpjcpf');

  // Verifica se deve mostrar os campos de pessoa juridica
  if ($oTomadorCpfCnpj.val()) {
    showCamposPessoaJuridicaAux($().returnNumbers($oTomadorCpfCnpj.val()));
  }
});

/**
 * Executa ao carregar a pagina
 */
$(function() {
  var $oForm = $('#nota');
  var $oEmitir = $('#emitir');
  var $oNaturezaOperacao = $('#natureza_operacao');
  var $oTomadorBuscador = $('#buscador');
  var $oTomadorCpfCnpj = $('#t_cnpjcpf');
  var $oTomadorNomeRazaoSocial = $('#t_razao_social');
  var $oTomadorCodigoUf = $('#t_uf');
  var $oTomadorCodigoMunicipio = $('#t_cod_municipio');
  var $oTomadorEndereco = $('#t_endereco');
  var $oTomadorEmail = $('#t_email');
  var $oServicoIssRetido = $('#s_dados_iss_retido');
  var $oServicoCodigoTributacao = $('#s_dados_cod_tributacao');
  var $oServicoCodigoUf = $('#estado');
  var $oServicoCodigoMunicipio = $('#s_dados_municipio_incidencia');
  var $oServicoValorAliquota = $('#s_vl_aliquota');
  var $oElementosEvitarEnter = $('form input, form select');
  var $oElmentosSelectReadonly = $('select[readonly] option:not(:selected)');
  var $oElementosLegend = $('legend');
  var $oElementosCalculoTotal  = $('#natureza_operacao, #s_dados_iss_retido, #s_vl_servicos, #s_vl_deducoes, #s_vl_desc_incondicionado');
  var $oElementosCalculoParcial = $('#s_vl_aliquota, #s_vl_bc, #s_vl_iss, #s_vl_inss, #s_vl_bc, #s_vl_pis, #s_vl_cofins, #s_vl_ir, #s_vl_csll, #s_vl_condicionado, #s_vl_outras_retencoes');
  var $oElementosNovoImprimirNota = $('#nova, #imprimir');
  var $oDataRps = $('#data_rps');
  var $oDataNota = $('#dt_nota');
  var $oValorDeducoes = $('#s_vl_deducoes');

  // Mascara para Data do RPS
  $oDataRps.datepicker({ 'format': 'dd/mm/yyyy' });

  // Bloqueia tela no submit do formulario
  $oEmitir.click(function() {
    $oForm.submit(function() {
      $oForm.find('input').attr('readonly', true);
      $oForm.find('select').attr('readonly', true);
      $oForm.find('textarea').attr('readonly', true);
      $oEmitir.html('Aguarde...').attr('disabled', true);
    });
  });

  // Previne submit ao pressionar 'Enter'
  $oElementosEvitarEnter.keypress(function(e) {
    if (e.which == 13) {
      e.preventDefault();
    }
  });

  // Abre/Fecha Legends
  $oElementosLegend.click(function() {

    $(this).find('~ *').each(function(i, div) {
      $(div).toggle();
    });
  });

  // Previne submit ao pressionar 'Enter'
  $oElementosEvitarEnter.keypress(function(e) {
    if (e.which == 13) {
      e.preventDefault();
    }
  });

  // Abre/Fecha Legends
  $oElementosLegend.click(function() {

    $(this).find('~ *').each(function(i, div) {
      $(div).toggle();
    });
  });

  // Bloqueia a seleção de options readonly
  $oElmentosSelectReadonly.attr('disabled', true);

  // Busca Tomador
  $oTomadorCpfCnpj.buscador({
    'statusInput': 'input#t_razao_social',
    'url'        : $oTomadorCpfCnpj.attr('url'),
    'data'       : { 'substituto': $oServicoIssRetido },
    'success'    : function(data) {

      limpaDadosTomador();

      if (data) {

        if (!data.uf) {
          data = data[0];
        }

        if (!!data.uf) {

          $oTomadorCodigoUf.val(data.uf);
          $oTomadorCodigoUf.change();
        }

        if (!!data.cod_ibge) {

          $oTomadorCodigoMunicipio.val(data.cod_ibge);
          $oTomadorCodigoMunicipio.change();
        }

        if (data.endereco) {
          $oTomadorEndereco.val(data.endereco);
        }

        if (data.substituto_tributario) {

          $oServicoIssRetido.attr('checked', true);
          $oServicoIssRetido.parent('').parent('').hide();
        } else {

          if ($oServicoIssRetido.attr('checked') == true) {
            $oServicoIssRetido.attr('checked', false);
          }

          $oServicoIssRetido.parent('').parent('').show();
        }

        showCamposPessoaJuridicaAux(data.cpf);
      }

      $.each(data, function(campo, valor) {

        var $oCampo = $('[campo-ref=' + campo + ']');
        var id1 = $oCampo.attr('id');
        var id2 = $oTomadorCpfCnpj.attr('id');

        if (valor != null && id1 != id2) {
          $oCampo.val(valor);
        }
      });

      $oTomadorEmail.focus();
    },
    not_found    : function() {

      limpaDadosTomador();
      showCamposPessoaJuridicaAux($oTomadorCpfCnpj.attr('value'));
    }
  });

  // Serviço retido
  $oServicoIssRetido.change(function(e) {

    // Verifica as regras da natureza da operação
    $oNaturezaOperacao.change();

    var sCnpjTomador = $().returnNumbers($oTomadorCpfCnpj.val());

    // Nao deixa marcar se for pessoa fisica
    if (sCnpjTomador.length < 14) {

      $(this).attr('checked', false);

      e.preventDefault();
      return;
    }

    if (!!$(this).attr('checked') === true && $oTomadorCpfCnpj.val() != '') {
      if ($oTomadorNomeRazaoSocial.val() == '') {
        $oTomadorBuscador.click();
      }
    }
  });

  // Troca do estado
  $oTomadorCodigoUf.change(function() {

    $oServicoCodigoUf.val($(this).val());
    $oServicoCodigoUf.change();
  });

  // Troca do municipio
  $oTomadorCodigoMunicipio.change(function() {
    $oServicoCodigoMunicipio.val($(this).val());
  });

  // Calculos
  $oElementosCalculoTotal.live('change', function() {
    calculaImpostos(true);
  });

  $oElementosCalculoParcial.live('change', function() {
    calculaImpostos(false);
  });

  // Botoes da nota emitida
  $oElementosNovoImprimirNota.click(function() {
    window.location.href = $(this).attr('url');
  });

  // Alteracao do Servico
  $oServicoCodigoTributacao.change(function() {

    var url = $(this).attr('url');
    var val = $(this).val();

    $.ajax({
      'url'    : url,
      'data'   : { 's': val },
      'error'  : function(xhr){
      	$().bloqueiaEmissao(xhr, $oForm);
      },
      'success': function(data) {
      	
      	if (data.erro) {
      		
      		if (data.servico != "") {
      			$().bloqueiaEmissao(data, $oForm);
      		}
      	} else {
	      		
	        // Altera a aliquota somente quando for campo de texto e não um select (optante simples) e natureza no município
	        if (data.aliq && $oServicoValorAliquota.is('input') && $oNaturezaOperacao.val() == '1') {
	
	          var valor_aliquota = $().number_format(data.aliq, 2, ',', '.');
	
	          $oServicoValorAliquota.val(valor_aliquota);
	        }
	
	        // Valida se o servico é de construção civil habilita a edição de dedução
	        $oValorDeducoes.attr('readonly', true).attr('habilita_deducao', false);
	
	        /** @namespace data.deducao */
	        if (data.deducao == 't') {
	          $oValorDeducoes.attr('readonly', false).attr('habilita_deducao', true);
	        }
	
	        // Recalcula valores
	        calculaImpostos(true);
      	}
      }
    });
  });

  // Alteracao Natureza Operacao
  $oNaturezaOperacao.change(function() {
  	
  	var $oFilds = $('#fieldset-dados_rps, #fieldset-tomador, #fieldset-grp_servico, #fieldset-valores');

    $oFilds.find('input').attr('disabled', false);
    $oFilds.find('select').attr('disabled', false);
    $oFilds.find('textarea').attr('disabled', false);
    $oFilds.find('button').attr('disabled', false);
    $oEmitir.attr('disabled', false);

    // Tributado dentro do municipio bloqueia a aliquota 
    if ($(this).val() == '1') {

      if ($oServicoValorAliquota.is('input')) {
        $oServicoValorAliquota.attr('readonly', true);
      }
    } else if ($(this).val() == '2') {

      $oServicoValorAliquota.attr('readonly', false);
      $oServicoIssRetido.attr('checked', false);
    } else {
    	
    	$oFilds.find('input').attr('disabled', true);
      $oFilds.find('select').attr('disabled', true);
      $oFilds.find('textarea').attr('disabled', true);
      $oFilds.find('button').attr('disabled', true);
      $oEmitir.attr('disabled', true);
    }

    $oServicoCodigoTributacao.change();
  });

  $oNaturezaOperacao.change();

  // Verifica se o contribuinte é optante pelo simples e habilita o campo com alíquotas do simples nacional
  $oDataNota.change(function() {
    var sValorAliquota = $oServicoValorAliquota.val();
    var sDataNota = $(this).val();

    // Campo padrão (preenchido conforme serviço)
    $oServicoValorAliquota.closest('div').html(
      '<input type="text" name="s_vl_aliquota" id="s_vl_aliquota" value="" class="span1 mask-porcentagem" ' +
        'readonly="readonly" style="text-align:right">' +
        '<span class="add-on">%</span></div>'
    );
    $oServicoValorAliquota = $('#s_vl_aliquota');
    $oServicoValorAliquota.val(sValorAliquota);

    // Se informada a data, verifica via webservice se o contribuinte é optante pelo simples
    if (sDataNota.length == 10) {

      $.ajax({
        dataType: 'json',
        url     : $oDataNota.attr('data-url'),
        data    : { 'data': sDataNota },
        error   : function(xhr){
        	$().bloqueiaEmissao(xhr, $oForm);
        },
        success : function(data) {
        	
        	if (data.erro) {
        		$().bloqueiaEmissao(data, $oForm);
        	} else {

	          // Mostra select com opções de aliquota
	          if (data.status) {
	
	            $oServicoValorAliquota.closest('div').html(
	              '<select name="s_vl_aliquota" id="s_vl_aliquota" class="span1">' +
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
	
	            $oServicoValorAliquota = $('#s_vl_aliquota');
	            $oServicoValorAliquota.val(sValorAliquota);
	          }
        	}
        }
      });
    }

    // Recalcula os valores
    $oServicoCodigoTributacao.change();
    $oNaturezaOperacao.change();

    // Readiciona as máscaras no campo
    $().addMascarasCampos();
  });

  $oDataNota.change();
});

/**
 * Funcoes Auxiliares
 */
function limpaDadosTomador() {

  $('#t_razao_social').val('');
  $('#t_nome_fantasia').val('');
  $('#t_im').val('');
  $('#t_ie').val('');
  $('#t_cod_pais').val('01058'); //valor padrão 01058 Brasil
  $('#t_uf').val(0).change();
  $('#t_cep').val('');
  $('#t_endereco').val('');
  $('#t_endereco_numero').val('');
  $('#t_endereco_comp').val('');
  $('#t_bairro').val('');
  $('#t_telefone').val('');
  $('#t_email').val('');
}

/**
 * Função auxiliar para mostrar os campos de pessoa
 *
 * @param str
 */
function showCamposPessoaJuridicaAux(str) {

  var iTamanho = $().returnNumbers(str.toString());

  showCamposPessoaJuridica(iTamanho.length);
}

/**
 * Mostra campos de pessoa jurídica
 *
 * @param iTamanho
 */
function showCamposPessoaJuridica(iTamanho) {

  var $oServicoIssRetido = $('#s_dados_iss_retido');
  var $oElementosPessoaJuridica = $('.pessoa_juridica');

  if (iTamanho <= 11) {

    $oElementosPessoaJuridica.closest('.control-group').hide();
    $oServicoIssRetido.attr('checked', false);

  } else {
    $oElementosPessoaJuridica.closest('.control-group').show();
  }
}

/**
 * Calcula os valores do serviço do documento
 *
 * @param lCarregarParametrosContribuinte [boolean]
 */
function calculaImpostos(lCarregarParametrosContribuinte) {

  var $oValorServicos   = $('#s_vl_servicos');
  var $oAliquota        = $('#s_vl_aliquota');
  var $oDeducoes        = $('#s_vl_deducoes');
  var $oInss            = $('#s_vl_inss');
  var $oPis             = $('#s_vl_pis');
  var $oCofins          = $('#s_vl_cofins');
  var $oIr              = $('#s_vl_ir');
  var $oCsll            = $('#s_vl_csll');
  var $oCondicionado    = $('#s_vl_condicionado');
  var $oIncondicionado  = $('#s_vl_desc_incondicionado');
  var $oOutrasRetencoes = $('#s_vl_outras_retencoes');
  var $oBaseCalculo     = $('#s_vl_bc');
  var $oIss             = $('#s_vl_iss');
  var $oValorLiquido    = $('#s_vl_liquido');

  // Flag para verificar se o prestador desconta o ISS na nota
  var lTomadorPagaIss = $('#s_dados_iss_retido').is(':checked') ? true : false;

  // Percentuais
  var perc_deducao  = isNaN($oDeducoes.attr('perc')) ? 0 : $oDeducoes.attr('perc');
  var perc_inss     = isNaN($oInss.attr('perc'))     ? 0 : $oInss.attr('perc');
  var perc_pis      = isNaN($oPis.attr('perc'))      ? 0 : $oPis.attr('perc');
  var perc_cofins   = isNaN($oCofins.attr('perc'))   ? 0 : $oCofins.attr('perc');
  var perc_ir       = isNaN($oIr.attr('perc'))       ? 0 : $oIr.attr('perc');
  var perc_csll     = isNaN($oCsll.attr('perc'))     ? 0 : $oCsll.attr('perc');
  var perc_aliquota = $oAliquota.val().replace(/\./g, '').replace(/,/g, '.');

  perc_aliquota = (perc_aliquota != '') ? perc_aliquota : 0;
  perc_aliquota = (perc_aliquota > 0) ? perc_aliquota : 0;

  // Valores
  var vlr_servico             = parseFloat($oValorServicos.val().replace(/\./g, '').replace(/,/g, '.'));
  var vlr_desc_condicionado   = parseFloat($oCondicionado.val().replace(/\./g, '').replace(/,/g, '.'));
  var vlr_desc_incondicionado = parseFloat($oIncondicionado.val().replace(/\./g, '').replace(/,/g, '.'));
  var vlr_outras_retencoes    = parseFloat($oOutrasRetencoes.val().replace(/\./g, '').replace(/,/g, '.'));

  // Verifica se tem valores vazios
  vlr_servico             = (vlr_servico != '')             ? vlr_servico             : 0;
  vlr_desc_condicionado   = (vlr_desc_condicionado != '')   ? vlr_desc_condicionado   : 0;
  vlr_desc_incondicionado = (vlr_desc_incondicionado != '') ? vlr_desc_incondicionado : 0;
  vlr_outras_retencoes    = (vlr_outras_retencoes != '')    ? vlr_outras_retencoes    : 0;

  // Verifica se tem valores negativos
  vlr_servico             = (vlr_servico > 0)             ? vlr_servico             : 0;
  vlr_desc_incondicionado = (vlr_desc_incondicionado > 0) ? vlr_desc_incondicionado : 0;
  vlr_outras_retencoes    = (vlr_outras_retencoes > 0)    ? vlr_outras_retencoes    : 0;

  // Calculos
  var vlr_deducao = 0;
  var vlr_liquido = 0;

  if ($oDeducoes.attr('habilita_deducao') == 'true') {

    vlr_deducao = $oDeducoes.val().replace(/\./g, '').replace(/,/g, '.');
    vlr_deducao = parseFloat(vlr_deducao.replace(',', '.'));
  } else {
    vlr_deducao = parseFloat(vlr_servico * (perc_deducao / 100));
  }

  // Valida se o valor de dedução é menor que o valor do serviço
  if (vlr_deducao < 0 || vlr_deducao >= vlr_servico) {
    vlr_deducao = 0;
  }

  var vlr_base    = parseFloat(vlr_servico - vlr_deducao - vlr_desc_incondicionado);
  var vlr_iss     = parseFloat($oIss.val().replace(/\./g, '').replace(/,/g, '.'));
  var vlr_inss    = parseFloat($oInss.val().replace(/\./g, '').replace(/,/g, '.'));
  var vlr_pis     = parseFloat($oPis.val().replace(/\./g, '').replace(/,/g, '.'));
  var vlr_cofins  = parseFloat($oCofins.val().replace(/\./g, '').replace(/,/g, '.'));
  var vlr_ir      = parseFloat($oIr.val().replace(/\./g, '').replace(/,/g, '.'));
  var vlr_csll    = parseFloat($oCsll.val().replace(/\./g, '').replace(/,/g, '.'));

  if (perc_aliquota > 0) {
    vlr_iss = vlr_base * (perc_aliquota / 100);
  }

  // Considera os parâmetros do contribuinte para calcular os valores dos impostos
  if (lCarregarParametrosContribuinte) {

    if (perc_inss > 0) {
      vlr_inss = vlr_base * (perc_inss / 100);
    }

    if (perc_pis > 0) {
      vlr_pis = vlr_servico * (perc_pis / 100);
    }

    if (perc_cofins > 0) {
      vlr_cofins = vlr_servico * (perc_cofins / 100);
    }

    if (perc_ir > 0) {
      vlr_ir = vlr_servico * (perc_ir / 100);
    }

    if (perc_csll > 0) {
      vlr_csll = vlr_servico * (perc_csll / 100);
    }
  }

  // Calcula o valor liquido
  if (vlr_servico > 0) {

    vlr_liquido = vlr_servico;
    vlr_liquido = vlr_liquido - vlr_pis;
    vlr_liquido = vlr_liquido - vlr_cofins;
    vlr_liquido = vlr_liquido - vlr_inss;
    vlr_liquido = vlr_liquido - vlr_ir;
    vlr_liquido = vlr_liquido - vlr_csll;
    vlr_liquido = vlr_liquido - vlr_outras_retencoes;
    vlr_liquido = vlr_liquido - vlr_desc_condicionado;
    vlr_liquido = vlr_liquido - vlr_desc_incondicionado;

    // Desconta o ISS do valor liquido se o tomador for o responśavel pelo ISS
    if (lTomadorPagaIss) {
      vlr_liquido -= vlr_iss;
    }
  }

  // Verifica se tem valores negativos (apos os calculos)
  if (vlr_liquido < 0) {
    vlr_liquido = 0;
  }

  // Formatação
  vlr_deducao             = $().number_format(vlr_deducao.toFixed(2).toString(), 2, ',', '.');
  vlr_base                = $().number_format(vlr_base.toFixed(2).toString(), 2, ',', '.');
  vlr_iss                 = $().number_format(vlr_iss.toFixed(2).toString(), 2, ',', '.');
  vlr_inss                = $().number_format(vlr_inss.toFixed(2).toString(), 2, ',', '.');
  vlr_pis                 = $().number_format(vlr_pis.toFixed(2).toString(), 2, ',', '.');
  vlr_cofins              = $().number_format(vlr_cofins.toFixed(2).toString(), 2, ',', '.');
  vlr_ir                  = $().number_format(vlr_ir.toFixed(2).toString(), 2, ',', '.');
  vlr_csll                = $().number_format(vlr_csll.toFixed(2).toString(), 2, ',', '.');
  vlr_liquido             = $().number_format(vlr_liquido.toFixed(2).toString(), 2, ',', '.');
  vlr_desc_condicionado   = $().number_format(vlr_desc_condicionado.toFixed(2).toString(), 2, ',', '.');
  vlr_desc_incondicionado = $().number_format(vlr_desc_incondicionado.toFixed(2).toString(), 2, ',', '.');
  vlr_outras_retencoes    = $().number_format(vlr_outras_retencoes.toFixed(2).toString(), 2, ',', '.');

  // Preenche os campos
  $oDeducoes.val(vlr_deducao);
  $oBaseCalculo.val(vlr_base);
  $oIss.val(vlr_iss);
  $oPis.val(vlr_pis);
  $oCofins.val(vlr_cofins);
  $oInss.val(vlr_inss);
  $oIr.val(vlr_ir);
  $oCsll.val(vlr_csll);
  $oOutrasRetencoes.val(vlr_outras_retencoes);
  $oCondicionado.val(vlr_desc_condicionado);
  $oIncondicionado.val(vlr_desc_incondicionado);
  $oValorLiquido.val(vlr_liquido);
}