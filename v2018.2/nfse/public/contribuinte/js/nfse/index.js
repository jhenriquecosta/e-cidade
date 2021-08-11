/**
 * Executa ao carregar a pagina
 */
$(function () {
  /**
   * Elementos do formulário
   */
  var form                   = $('#form-nota');
  var cnpjCpfTomador         = $('#t_cnpjcpf');
  var dataNota               = $('#dt_nota');
  var notaSubstituta         = $('#nota_substituta');
  var naturezaOperacao       = $('#natureza_operacao');
  var servico                = $('#s_dados_cod_tributacao');
  var municipioServico       = $('#s_dados_municipio_incidencia');
  var substitutoTributario   = $('#substituto_tributario');
  var cooperado              = $('#t_cooperado');
  var issRetido              = $('#s_iss_retido');
  var fieldSetTomador        = $('#fieldset-tomador');
  var fieldSetValoresServico = $('#fieldset-valores');
  var btnEmitir              = $('#emitir');
  var lblLegenda             = $('legend');
  var lstEvitarEnter         = $('form input, form select');
  var lstCalculoTotal        = $('#s_dados_iss_retido, #s_vl_servicos, #s_vl_deducoes, #s_vl_desc_incondicionado');
  var lstCalculoParcial      = $('#s_vl_aliquota, #s_vl_bc, #s_vl_iss, #s_vl_inss, #s_vl_bc, #s_vl_pis, #s_vl_cofins, #s_vl_ir, #s_vl_csll, #s_vl_condicionado, #s_vl_outras_retencoes');
  var servicoNaoIncide       = $('#s_nao_incide');
  var exigibilidade          = $('#s_dados_exigibilidadeiss');
  var paisTomador            = $('#t_cod_pais');
  var paisServico            = $('#s_dados_cod_pais');
  var regimeTributario       = $('#p_regime_tributario');

  /**
   * CONSTANTES
   */
  const CODIGO_BRASIL = 01058;

  /**
   * Aplica a regra para o grupo de serviço que possui valor de alíquota fixada
   */
  function regraFixado(tributacao_fixada, aliquota, naturezaOperacao) {

    //Altera para aliquota 0 se a tributação do grupo de serviço for fixada e o contribuinte não for simples
    if (tributacao_fixada == 't' && aliquota.is('input') && naturezaOperacao == '1' || $('#s_nao_incide').val() == '1') {

      if ($('#s_dados_exigibilidadeiss').val() == '27') {
        // IMUNIDADE
        $("div.input-append span.add-on").text('IMUNIDADE');
        issRetido.val(0);
        $('#s_vl_aliquota').val(0);
       } else if ($('#s_nao_incide').val() == '1') {
         $("div.input-append span.add-on").text('NÃO INCIDE');
         issRetido.val(0);
       } else {
        $("div.input-append span.add-on").text('FIXADA');
        aliquota.val($().number_format(0, 2, ',', '.'));
       }

      aliquota.hide();
    } else {

      $("div.input-append span.add-on").text('%');
      aliquota.show();
    }
  }
  /**
   * Busca os dados da nota copiada
   */
  function buscaDadosNota() {

    if ($.url().segment(-2) == 'id_copia') {

      var url        = '/contribuinte/nfse/obtem-dados-nota/';
      var idCopia    = $.url().segment(-1);
      var form       = $(this).closest('form');
      var localCache = {
        data: {},
        remove: function (url) {
          delete localCache.data[url];
        },
        exist: function (url) {
          return localCache.data.hasOwnProperty(url) && localCache.data[url] !== null;
        },
        get: function (url) {
          return localCache.data[url];
        },
        set: function (url, cachedData, callback) {
          localCache.remove(url);
          localCache.data[url] = cachedData;
          if ($.isFunction(callback)) callback(cachedData);
        }
      };
      // Consulta os dados da nota
      $.ajax({
        url: url,
        data: {'id_copia': idCopia},
        cache: true,
        beforeSend: function () {

          form.find('input, select, textarea').attr('readonly', true);
          btnEmitir.html('Aguarde...').attr('disabled', true);
          if (localCache.exist(url)) {

            populaFormularioNota(localCache.get(url));
            return false;
          }

          return true;
        },
        complete: function (jqXHR, textStatus) {

          form.find('input, select, textarea').attr('readonly', false);
          btnEmitir.html('Emitir').attr('disabled', false);
          localCache.set(url, jqXHR, populaFormularioNota);
        }
      });
    }
  }
  /**
   * Preenche os valores no formulário com os dados da nota
   */
  function populaFormularioNota(cache) {

    var dadosNota = $.parseJSON(cache.responseText);
    if (dadosNota.data) {

      $.each(dadosNota.data, function(elemento, valor) {
        $('#'+elemento).val(valor);
      });

      if(dadosNota.data.t_cooperado){
        $('#t_cooperado option:eq(1)').prop('selected', true);
      }

      // Verifica se foi informado um CPF/CNPJ consulta os dados do tomador no e-cidade
      if ($('#t_cnpjcpf').val()) {
        $('#buscador').click();
      }

      // Verifica o serviço prestado
      $('#s_dados_cod_tributacao').val(dadosNota.data.s_dados_cod_tributacao).change();

      /**
       * Executamos o change do pais, para que as regras de Incidência do imposto sejam validadas
       * e mostradas corretamente no formulário
       */
      paisServico.change();

      //Selecionamos o estado do serviço prestado
      $('#estado').val(dadosNota.data.estado).change();

      // Seleciona o município do serviço prestado
      $('#s_dados_municipio_incidencia').val(dadosNota.data.s_dados_municipio_incidencia).change();

      // Valida as regras do serviço atualizado
      validaRegraCalculoServico({});

      // Recalcula os valores
      lstCalculoTotal.change();

      // Verifa as regras de emissão do formulário
      validaRegraEmissao();
    }

    $().addMascarasCampos();
  }
  /**
   * Verifica os campos que são obrigatório o preenchimento
   */
  function verificaPreenchimentoFormulario() {

    var camposValidacao = [
      dataNota
    ];

    // Marca os campos não preenchidos nos dados da nota
    marcaCampoNaoPreenchido(camposValidacao, $('#fieldset-dados_nota'));

    // Marca os campos não preenchidos nos dados do tomador
    marcaCampoNaoPreenchido(null, fieldSetTomador);

    var camposValidacao = [
      servico,
      $("#descricao")
    ];

    // Valida local de prestação do serviço
    if ($('#s_dados_cod_pais').val() == '01058') {
      camposValidacao.push($('#estado'),$('#s_dados_municipio_incidencia'));
    } else {
      camposValidacao.push($('#s_dados_cidade_estado'));
    }
    // Marca os campos não preenchidos nos dados do serviço prestado
    marcaCampoNaoPreenchido(camposValidacao, $("#fieldset-grp_servico"));

    // Marca os campos não preenchidos nos dados da tributação
    marcaCampoNaoPreenchido(null, $('#fieldset-dados_tributacao'));

    var camposValidacao = [
      $('#s_vl_servicos')
    ];

     if ($('#s_nao_incide').val() == 0 && $('#b_mei_sociedade_profissionais').val() == 0 && $("div.input-append span.add-on").text() == '%') {
       camposValidacao.push($('#s_vl_aliquota'));
     } else {
       $('#s_vl_aliquota').removeClass('error');
     }

    // Marca os campos não preenchidos dos valores do serviço
    marcaCampoNaoPreenchido(camposValidacao, fieldSetValoresServico);

    if ($('#nota_substituta').is(':checked')) {
      // Marca os campos não preenchidos nos dados da nota
      marcaCampoNaoPreenchido([$('#nota_substituida')], $('#fieldset-dados_nota'));
    }
  }
  /**
   * Marca os campos que não estão preenchidos conforme o fieldset informado
   *
   * @param array element
   * @param object fieldSet
   */
  function marcaCampoNaoPreenchido(camposValidacao, fieldSet) {

    if (camposValidacao) {

      $(fieldSet).find('input, select, textarea').removeClass('error');
      $.each(camposValidacao, function(indice, elemento) {

          $(elemento).removeClass('error');
        // Verifica se o campo está vazio
        if ($(elemento).val() == ''
          || ($('#s_vl_aliquota').is('input')
          && $(elemento).val() == null || Number($(elemento).val().replace(',','.')) <= Number(0)
          && ($("div.input-append span.add-on").text() !== 'FIXADA' || $("div.input-append span.add-on").text() !== 'NÃO INCIDE'))) {

          $(elemento).addClass('error');
        }
      });
    }

    // Sinaliza o field set do campo vazio
    if ($(fieldSet).find('input, select, textarea').hasClass('error')) {
      $(fieldSet).removeClass('validation-accept').addClass('validation-cancel');
    } else {
      $(fieldSet).removeClass('validation-cancel').addClass('validation-accept');
    }
  }
  /**
   * Faz a validação das regras de emissão da NFS-e
   */
  function validaRegraEmissao() {

    // Se o contribuinte for isento impede de reter
    if ($('#s_dados_exigibilidadeiss').val() == '25') {
      issRetido.val('0').attr('readonly', true).attr('disabled', true);
    } else if (municipioServico.data('municipio-origem') != municipioServico.val() ) {

      // console.log('[1]Serviço não foi prestado no municipio do prestador');

      // Serviço não foi prestado no municipio do prestador
      var servicoTributadoMunicipio = $('#s_tributacao_municipio');

      if (servicoTributadoMunicipio.val() == 't') {

        // console.log('[1.1]Serviço não permite retenção fora do municipio');

        // Serviço não permite retenção fora do municipio
        $("#natureza_operacao option[value='2']").attr('readonly', true).attr('disabled', true);

        // Natureza da operação é de tributação no municipio
        if (naturezaOperacao.val() == '1') {
          issRetido.val('0').attr('readonly', true).attr('disabled', true);
        }
      } else {

        // console.log('[1.2]Serviço permite a retenção dentro ou fora do município');

        // Serviço permite a retenção dentro ou fora do município
        $("#natureza_operacao option[value='2']").attr('readonly', false).attr('disabled', false);

        if (naturezaOperacao.val() == '1') {

          // console.log('[1.3]Natureza da operação é de tributação no municipio');

          // Natureza da operação é de tributação no municipio
          issRetido.val('0').attr('readonly', true).attr('disabled', true);
        } else {

          // console.log('[1.4]Natureza da operação é de tributação fora do municipio');

          // Natureza da operação é de tributação fora do municipio

          if ($('#b_mei_sociedade_profissionais').val() != '1' && $('#s_nao_incide').val() != '1') {
            issRetido.attr('readonly', false).attr('disabled', false);

            // Serviço permite retenção fora do municipio habilita a digitação do valor da alíquota
            $('#s_vl_aliquota').attr('readonly', false).attr('disabled', false);
          }

          //Regra do MEI/Sociedade de Profissionais
          if ($('#b_mei_sociedade_profissionais').val() != '1' && $('#s_nao_incide').val() != '1') {
            regraFixado('f', $('#s_vl_aliquota'), naturezaOperacao.val());
          }
        }
      }
    } else {

      // console.log('[2]Serviço foi prestado no municipio do prestador');

      // Serviço foi prestado no municipio do prestador
      $("#natureza_operacao option[value='2']").attr('readonly', true).attr('disabled', true);

      if (substitutoTributario.val() == '1' && $('#b_mei_sociedade_profissionais').val() != '1' && $('#s_nao_incide').val() != '1') {

        // console.log('[2.1]Tomador é substituto tributário, marca tributação no município');

        // Tomador é substituto tributário, marca tributação no município
        if (naturezaOperacao.val() == '1') {
          issRetido.val('1').attr('readonly', true).attr('disabled', true);
        }
      } else {

        // console.log('[2.2]Verifica se o tomador é de fora do municipio');

        // Verifica se o tomador é de fora do municipio
        if (substitutoTributario.data('nao-e-do-municipio')) {

          // console.log('[2.3]Verifica se o tomador é de fora do municipio');

          // Tomador não é do municipio
          substitutoTributario.val('0');
          if ($('#b_mei_sociedade_profissionais').val() != '1' && $('#s_nao_incide').val() != '1') {
            issRetido.val('0').attr('readonly', false).attr('disabled', false);
          }
          fieldSetTomador.find('#substituto_tributario, [for="substituto_tributario"]').hide();
        } else {
          // console.log('[2.4]Tomador é do município');

          // Tomador é do município
          fieldSetTomador.find('#substituto_tributario, [for="substituto_tributario"]').show();
        }

        // Tomador não é substituto tributário pode selecionar a retenção
        if ($('#b_mei_sociedade_profissionais').val() != '1' && $('#s_nao_incide').val() != '1') {
          issRetido.attr('readonly', false).attr('disabled', false);
        }
      }
    }

    issRetido.change();
    regraCooperado();
  }
  /**
   * Valida as regras do calculo de imposto para o serviço
   * @param object data
   */
  function validaRegraCalculoServico(data) {

    var valorServico = $('#s_vl_servicos');
    var aliquota = $('#s_vl_aliquota');

    // Se for informado um data record faz a validação dos parâmetros da requisição
    if (data) {

      // Valida se o servico é de construção civil habilita a edição de dedução
      var deducao = $('#s_vl_deducoes');
      deducao.attr('readonly', true).attr('habilita_deducao', false);
      if (data.deducao == 't') {
        deducao.attr('readonly', false).attr('habilita_deducao', true);
      }

      // Desabilita a seleção de aliquota apenas se for o combo de seleção para optante do simples nacional
      aliquota.attr('readonly', true).attr('disabled', false);
      if (aliquota.is('select')) {
        aliquota.attr('readonly', false).attr('disabled', false);
      }

      //Altera a aliquota somente quando for campo de texto e não um select (optante simples) e natureza no município
      if (((data.aliq && aliquota.is('input') && naturezaOperacao.val() == '1' )
          || (aliquota.is('input') && data.tributacao_municipio == 't'))
        && $('#b_mei_sociedade_profissionais').val() != '1') {

        aliquota.val($().number_format(data.aliq, 2, ',', '.'));

        // Verificação para a regra do grupo de serviço com valor fixado
        regraFixado(data.tributacao_fixada, aliquota, naturezaOperacao.val());
      }

      if($("#t_cooperado option:selected").val() == 'true' && regimeTributario.val() == 15){

        $('#s_vl_aliquota').hide();
        $('#s_vl_aliquota').val('');
        $('div.input-append span.add-on').text('NÃO INCIDE');
      }

      $('#s_vl_servicos').val('');
      $('#s_vl_liquido').val('');
      $('#s_vl_iss').val('');
      $('#s_vl_bc').val('');
      $('#s_vl_servicos').attr('readonly', false);
      $('#s_vl_cofins').attr('readonly', false);
      $('#s_vl_csll').attr('readonly', false);
      $('#s_vl_condicionado').attr('readonly', false);
      $('#s_vl_inss').attr('readonly', false);
      $('#s_vl_pis').attr('readonly', false);
      $('#s_vl_ir').attr('readonly', false);
      $('#s_vl_outras_retencoes').attr('readonly', false);
      $('#s_vl_desc_incondicionado').attr('readonly', false);

      fieldSetValoresServico.removeAttr('disabled');

      // Recalcula valores
      calculaImpostos(true);
    }
  }

  /**
  * Define a lista de atividades
  * @param data
  * @param codigoServicoTributacao
  */
  function defineListaAtividades(data, codigoServicoTributacao) {

    $.ajax({
      'asinc'    : true,
      'url'      : '/contribuinte/nfse/define-lista-atividades/',
      'data'     : { 'data_emissao': data },
      'error'    : function(xhr){
        $().bloqueiaEmissao(xhr, form);
      },
      'success'  : function(data) {

        oListaAtividades                = document.getElementById('s_dados_cod_tributacao');
        oListaAtividades.options.length = 0;

        var opt       = new Option('', '', false, false);
        opt.innerHTML = '- Escolha um Serviço -';
        oListaAtividades.appendChild(opt);

        $.each(data, function(campo, valor) {

          var bSelected = false;
          if (codigoServicoTributacao == campo) {

            // Ajusta o valor do serviço selecionado na copia da nota
            $('#s_dados_cod_tributacao_copia').val(codigoServicoTributacao);
            bSelected = true;
          }

          var opt       = new Option(null, campo, false, bSelected);
          opt.innerHTML = valor;
          oListaAtividades.appendChild(opt);
        });

        // Ajusta o valor do serviço selecionado na copia da nota
        if ($('#s_dados_cod_tributacao_copia').val() != '') {
          servico.val($('#s_dados_cod_tributacao_copia').val());
        }
      }
    });
  }
  /**
  * Calcula os valores do serviço do documento
  * @param lCarregarParametrosContribuinte
  */
  function calculaImpostos(lCarregarParametrosContribuinte) {

    var txtValorServicos   = $('#s_vl_servicos');
    var txtAliquota        = $('#s_vl_aliquota');
    var txtDeducoes        = $('#s_vl_deducoes');
    var txtInss            = $('#s_vl_inss');
    var txtPis             = $('#s_vl_pis');
    var txtCofins          = $('#s_vl_cofins');
    var txtIr              = $('#s_vl_ir');
    var txtCsll            = $('#s_vl_csll');
    var txtCondicionado    = $('#s_vl_condicionado');
    var txtIncondicionado  = $('#s_vl_desc_incondicionado');
    var txtOutrasRetencoes = $('#s_vl_outras_retencoes');
    var txtBaseCalculo     = $('#s_vl_bc');
    var txtIss             = $('#s_vl_iss');
    var txtValorLiquido    = $('#s_vl_liquido');

    // Flag para verificar se o prestador desconta o ISS na nota
    var lTomadorPagaIss = $('#s_dados_iss_retido').val();

    // Percentuais
    var perc_deducao  = ajustaValoresCalculo(txtDeducoes.attr('perc'));
    var perc_inss     = ajustaValoresCalculo(txtInss.attr('perc'));
    var perc_pis      = ajustaValoresCalculo(txtPis.attr('perc'));
    var perc_cofins   = ajustaValoresCalculo(txtCofins.attr('perc'));
    var perc_ir       = ajustaValoresCalculo(txtIr.attr('perc'));
    var perc_csll     = ajustaValoresCalculo(txtCsll.attr('perc'));
    var perc_aliquota = txtAliquota.val().replace(/\./g, '').replace(/,/g, '.');

    perc_aliquota = ajustaValoresCalculo(perc_aliquota);

    // Valores
    var vlr_servico             = parseFloat(txtValorServicos.val().replace(/\./g, '').replace(/,/g, '.'));
    var vlr_desc_condicionado   = parseFloat(txtCondicionado.val().replace(/\./g, '').replace(/,/g, '.'));
    var vlr_desc_incondicionado = parseFloat(txtIncondicionado.val().replace(/\./g, '').replace(/,/g, '.'));
    var vlr_outras_retencoes    = parseFloat(txtOutrasRetencoes.val().replace(/\./g, '').replace(/,/g, '.'));

    // Calculos
    var vlr_deducao = 0;
    var vlr_liquido = 0;

    if (txtDeducoes.attr('habilita_deducao') == 'true') {

      vlr_deducao = txtDeducoes.val().replace(/\./g, '').replace(/,/g, '.');
      vlr_deducao = parseFloat(vlr_deducao.replace(',', '.'));
    } else {
      vlr_deducao = parseFloat(ajustaValoresCalculo(vlr_servico) * (ajustaValoresCalculo(perc_deducao) / 100));
    }

    // Valida se o valor de dedução é menor que o valor do serviço
    if (vlr_deducao < 0 || vlr_deducao >= vlr_servico) {
      vlr_deducao = 0;
    }

    vlr_servico             = ajustaValoresCalculo(vlr_servico);
    vlr_deducao             = ajustaValoresCalculo(vlr_deducao);
    vlr_desc_incondicionado = ajustaValoresCalculo(vlr_desc_incondicionado);

    var vlr_base   = parseFloat(vlr_servico - vlr_deducao - vlr_desc_incondicionado);
    var vlr_iss    = parseFloat(txtIss.val().replace(/\./g, '').replace(/,/g, '.'));
    var vlr_inss   = parseFloat(txtInss.val().replace(/\./g, '').replace(/,/g, '.'));
    var vlr_pis    = parseFloat(txtPis.val().replace(/\./g, '').replace(/,/g, '.'));
    var vlr_cofins = parseFloat(txtCofins.val().replace(/\./g, '').replace(/,/g, '.'));
    var vlr_ir     = parseFloat(txtIr.val().replace(/\./g, '').replace(/,/g, '.'));
    var vlr_csll   = parseFloat(txtCsll.val().replace(/\./g, '').replace(/,/g, '.'));

    if (perc_aliquota > 0) {
      vlr_iss = ajustaValoresCalculo(vlr_base) * (ajustaValoresCalculo(perc_aliquota) / 100);
    }

    // Considera os parâmetros do contribuinte para calcular os valores dos impostos
    if (lCarregarParametrosContribuinte) {

      if (perc_inss > 0) {
        vlr_inss = ajustaValoresCalculo(vlr_base) * (ajustaValoresCalculo(perc_inss) / 100);
      }

      if (perc_pis > 0) {
        vlr_pis = ajustaValoresCalculo(vlr_servico) * (ajustaValoresCalculo(perc_pis) / 100);
      }

      if (perc_cofins > 0) {
        vlr_cofins = ajustaValoresCalculo(vlr_servico) * (ajustaValoresCalculo(perc_cofins) / 100);
      }

      if (perc_ir > 0) {
        vlr_ir = ajustaValoresCalculo(vlr_servico) * (ajustaValoresCalculo(perc_ir) / 100);
      }

      if (perc_csll > 0) {
        vlr_csll = ajustaValoresCalculo(vlr_servico) * (ajustaValoresCalculo(perc_csll) / 100);
      }
    }

    // Round
    vlr_deducao             = vlr_deducao.toFixed(2);
    vlr_base                = vlr_base.toFixed(2);
    vlr_iss                 = vlr_iss.toFixed(2);
    vlr_inss                = vlr_inss.toFixed(2);
    vlr_pis                 = vlr_pis.toFixed(2);
    vlr_cofins              = vlr_cofins.toFixed(2);
    vlr_ir                  = vlr_ir.toFixed(2);
    vlr_csll                = vlr_csll.toFixed(2);
    vlr_liquido             = vlr_liquido.toFixed(2);
    vlr_desc_condicionado   = vlr_desc_condicionado.toFixed(2);
    vlr_desc_incondicionado = vlr_desc_incondicionado.toFixed(2);
    vlr_outras_retencoes    = vlr_outras_retencoes.toFixed(2);

    // Calcula o valor liquido
    if (vlr_servico > 0) {

      vlr_liquido = ajustaValoresCalculo(vlr_servico);
      vlr_liquido = vlr_liquido - ajustaValoresCalculo(vlr_pis);
      vlr_liquido = vlr_liquido - ajustaValoresCalculo(vlr_cofins);
      vlr_liquido = vlr_liquido - ajustaValoresCalculo(vlr_inss);
      vlr_liquido = vlr_liquido - ajustaValoresCalculo(vlr_ir);
      vlr_liquido = vlr_liquido - ajustaValoresCalculo(vlr_csll);
      vlr_liquido = vlr_liquido - ajustaValoresCalculo(vlr_outras_retencoes);
      vlr_liquido = vlr_liquido - ajustaValoresCalculo(vlr_desc_condicionado);
      vlr_liquido = vlr_liquido - ajustaValoresCalculo(vlr_desc_incondicionado);

      // Desconta o ISS do valor liquido se o tomador for o responsavel pelo ISS
      if (lTomadorPagaIss == '1' && (txtAliquota.is('input') || $('#p_categoria_simples_nacional').val() != 3)) {
        vlr_liquido -= vlr_iss;
      }
    }

    // Verifica se tem valores negativos (apos os calculos)
    if (vlr_liquido < 0) {
      vlr_liquido = 0;
    }

    // Formatação
    vlr_deducao             = $().number_format(vlr_deducao.toString(), 2, ',', '.');
    vlr_base                = $().number_format(vlr_base.toString(), 2, ',', '.');
    vlr_iss                 = $().number_format(vlr_iss.toString(), 2, ',', '.');
    vlr_inss                = $().number_format(vlr_inss.toString(), 2, ',', '.');
    vlr_pis                 = $().number_format(vlr_pis.toString(), 2, ',', '.');
    vlr_cofins              = $().number_format(vlr_cofins.toString(), 2, ',', '.');
    vlr_ir                  = $().number_format(vlr_ir.toString(), 2, ',', '.');
    vlr_csll                = $().number_format(vlr_csll.toString(), 2, ',', '.');
    vlr_liquido             = $().number_format(vlr_liquido.toString(), 2, ',', '.');
    vlr_desc_condicionado   = $().number_format(vlr_desc_condicionado.toString(), 2, ',', '.');
    vlr_desc_incondicionado = $().number_format(vlr_desc_incondicionado.toString(), 2, ',', '.');
    vlr_outras_retencoes    = $().number_format(vlr_outras_retencoes.toString(), 2, ',', '.');

    // Preenche os campos
    txtDeducoes.val(vlr_deducao);
    txtBaseCalculo.val(vlr_base);
    txtIss.val(vlr_iss);
    txtPis.val(vlr_pis);
    txtCofins.val(vlr_cofins);
    txtInss.val(vlr_inss);
    txtIr.val(vlr_ir);
    txtCsll.val(vlr_csll);
    txtOutrasRetencoes.val(vlr_outras_retencoes);
    txtCondicionado.val(vlr_desc_condicionado);
    txtIncondicionado.val(vlr_desc_incondicionado);
    txtValorLiquido.val(vlr_liquido);
  }
  /**
  * Método para ajustar os valores de calculo nulos, vazios e NaN
  * @param valor
  */
  function ajustaValoresCalculo(valor) {

    // Verifica se tem valores indefinidos
    valor = (isNaN(valor)) ? 0 : valor;

    // Verifica se tem valores vazios
    valor = (valor == '') ? 0 : valor;

    // Verifica se tem valores negativos
    valor = (valor > 0) ? valor : 0;

    return valor;
  }
  /**
   * Carrega as aliguotas quando contribuinte for optante pelo simples
   * @param valorDataNota
   */
  function carregaAliquota(valorDataNota) {

    $.ajax({
      'asinc'    : true,
      'dataType' : 'json',
      'url'      : dataNota.attr('data-url'),
      'data'     : { 'data': valorDataNota },
      'error'    : function(xhr){
        $().bloqueiaEmissao(xhr, form);
      },
      'success'  : function(data) {

        if (data.erro) {
          $().bloqueiaEmissao(data, form);
        } else {

          // Categoria do simples nacional
          $('#p_categoria_simples_nacional').val(data.optante_simples_categoria);

          // Regra de regime tributario MEI/Sociedade de Profissionais
          if (
              data.regime_tributario_mei
              || data.regime_tributario_sociedade_profissionais
              || $('#s_dados_exigibilidadeiss').val() == '27'
              || (data.optante_simples_nacional == false && data.regime_tributario_fixado == true)
            ) {

            $('#b_mei_sociedade_profissionais').val(1);
            $('#s_iss_retido').attr('readonly','readonly');
            regraFixado('t',$('#s_vl_aliquota'), 1);

          } else {

            sValorAliquota = data.valor_iss_fixo;

            // Mostra select com opções de aliquota
            if (data.optante_simples_nacional) {

              var sCategorias = '<select '
                              + 'name="s_vl_aliquota" '
                              + 'id="s_vl_aliquota" '
                              + 'class="input-small" '
                              + 'readonly="readonly"  '
                              + 'disabled="disabled"'
                              + '>';

              /**
               * Optante pelo simples - mei
               */
              if (data.optante_simples_categoria == 3) {

                sValorAliquota = "";
                sCategorias   += '<option value="0,00">0</option>';
              }

              sCategorias += '<option value="2,00">2</option>';
              sCategorias += '<option value="2,79">2,79</option>';
              sCategorias += '<option value="3,50">3,5</option>';
              sCategorias += '<option value="3,84">3,84</option>';
              sCategorias += '<option value="3,87">3,87</option>';
              sCategorias += '<option value="4,23">4,23</option>';
              sCategorias += '<option value="4,26">4,26</option>';
              sCategorias += '<option value="4,31">4,31</option>';
              sCategorias += '<option value="4,61">4,61</option>';
              sCategorias += '<option value="4,65">4,65</option>';
              sCategorias += '<option value="5,00">5</option>';
              sCategorias += '</select>';
              sCategorias += '<span class="add-on">%</span>';

              $('#s_vl_aliquota').closest('div').html(sCategorias);
            }

            $('#s_vl_aliquota').val(sValorAliquota);

          }

        }

        // Recalcula os valores ao selecionar uma aliquota
        $('#s_vl_aliquota').change(function() {
          calculaImpostos(true);
        });
      }
    });
  }
  /**
  * Limpa os campos com os dados do tomador
  */
  function limpaDadosTomador() {

    $('#t_razao_social').val('');
    $('#t_nome_fantasia').val('');
    $('#t_im').val('');
    $('#t_ie').val('');
    $('#t_cod_pais').val('01058'); //valor padrão 01058 Brasil
    $('#t_uf').val('');
    $('#t_cep').val('');
    $('#t_endereco').val('');
    $('#t_endereco_numero').val('');
    $('#t_endereco_comp').val('');
    $('#t_bairro').val('');
    $('#t_telefone').val('');
    $('#t_email').val('');
  }

  /**
   * Verifica se o tomador é substituto tributário e se está cadastrado no município
   * @param data
   */
  var verificaTomadorMunicipio = function(data) {

    substitutoTributario.data('nao-e-do-municipio', false);

    if (typeof data.substituto_tributario != "undefined") {
      substitutoTributario.val((data.substituto_tributario) ? '1' : '0');
    } else {
      substitutoTributario.data('nao-e-do-municipio', true);
    }

    validaRegraEmissao();
  }

  /**
   * Metodo para verificar a regra de tributação não incide pelo grupo de serviço
   * @param data
   */
  var regraNaoIncide = function(data) {

    if($('#s_dados_fora_incide').val() == 1 || $('#b_mei_sociedade_profissionais').val() == 1) {

      if (data.tributacao_nao_incide == 't') {

        if ($('#s_vl_aliquota').is('select')) {

          if ($('#p_categoria_simples_nacional').val() == 3) {
            $('#s_vl_aliquota option[value=0,00]').attr('selected','selected');
          } else {
            $("#s_vl_aliquota").append("<option value='0,00' selected=''>0</option>");
          }

        } else {
          $("#s_vl_aliquota").val(0);
        }

        $("#s_vl_aliquota").hide();
        $("div.input-append span.add-on").text('NÃO INCIDE');
        $('#s_iss_retido').val(0).attr('readonly','readonly');

      } else {

        if ($('#s_vl_aliquota').is('select')) {

          if ($('#p_categoria_simples_nacional').val() != 3) {
            $("#s_vl_aliquota option[value='0,00']").remove();
          }
        } else {
          $("#s_vl_aliquota").val(data.aliq);
        }

        $("#s_vl_aliquota").show();
        $("div.input-append span.add-on").text('%');
        $('#s_vl_aliquota').attr('disabled', false).attr('readonly', false).show();

        if ($('#b_mei_sociedade_profissionais').val() == 1) {

          $('#s_iss_retido').attr('readonly','readonly');
          regraFixado('t',$('#s_vl_aliquota'), 1);
        }
      }
    } else {

      $("#s_vl_aliquota").hide();
      $("div.input-append span.add-on").text('NÃO INCIDE');
    }
  }

  function regraCooperado(){

    if(regimeTributario.val() == 15){

      if($("#t_cooperado option:selected").val() == 'true'){

        $("#natureza_operacao option[value='1']").prop("selected", true);
        $("#natureza_operacao option[value='2']").attr("readonly", true).attr("disabled", true);

      }else if(municipioServico.data('municipio-origem') != municipioServico.val()){
        $("#natureza_operacao option[value='2']").attr("readonly", false).attr("disabled", false);
      }
    }
  }

  /**
  * Calculo Total
  */
  lstCalculoTotal.change(function() {
    calculaImpostos(true);
  });
  /**
  * Calculo Parcial
  */
  lstCalculoParcial.change(function() {
    calculaImpostos(false);
  });
  /**
  * Verifica se o contribuinte é optante pelo simples e habilita o campo com alíquotas do simples nacional
  */
  dataNota.change(function() {

    var valorAliquota = $('#s_vl_aliquota').val();
    var valorDataNota = $(this).val();

    // Campo padrão (preenchido conforme serviço)
    $('#s_vl_aliquota').closest('div').html(
      '<input type="text" name="s_vl_aliquota" id="s_vl_aliquota" value="" class="span1 mask-porcentagem" ' +
      'readonly="readonly" style="text-align:right">' +
      '<span class="add-on">%</span></div>'
    ).val(valorAliquota);

    // Se informada a data, verifica via webservice se o contribuinte é optante pelo simples
    if (valorDataNota && valorDataNota.length == 10) {

      // Define a lista das atividade de serviço
      defineListaAtividades(valorDataNota, servico.val());

      // Adiciona a lista das aliquotas
      carregaAliquota(valorDataNota);

      // Recalcula os valores
      servico.change();

      // Valida as regras de emissão da NFS-e
      validaRegraEmissao();

      // Readiciona as máscaras no campo
      $().addMascarasCampos();
    } else {

      bootbox.alert('Nenhuma data para a emissão encontrada!');
      $('form input, form select, form textarea, form button').attr('readonly', true);
      $('form input, form select, form textarea, form button').attr('disabled', true);
    }
  });
  /**
  * Exibe o campo para nota substituta
  */
  notaSubstituta.change(function() {

    if ($(this).attr('checked')) {
      $('#nota_substituida').closest('.control-group').show();
      $('#nota_substituida').show().focus();
    } else {
      $('#nota_substituida').closest('.control-group').hide();
      $('#nota_substituida').hide();
    }
  });

  cooperado.change(function(){
    servico.change();
  });

  /**
   * Alteracao do Servico
   */
  servico.change(function() {

    var codigoServico             = $(this).val();
    var servicoTributadoMunicipio = $('#s_tributacao_municipio');

    // Carrega os estados de origem do serviço
    $('#estado').change();

    if (codigoServico) {

      servicoTributadoMunicipio.val('f');

      $.ajax({
        'asinc'    : true,
        'url'      : '/contribuinte/nfse/get-servico/',
        'data'     : { 'servico' : codigoServico, 'exercicio' : dataNota.val()},
        'error'    : function(xhr){
          $().bloqueiaEmissao(xhr, form);
        },
        'success'  : function(data) {

          if (data) {

            if(data.erro){
              $().bloqueiaEmissao(data, form);
            } else {

              servicoNaoIncide.val((data.tributacao_nao_incide == 't') ? 1 : 0);
              servicoTributadoMunicipio.val(data.tributacao_municipio);

              regraNaoIncide(data);

              // Valida as regras de emissão da NFS-e
              validaRegraEmissao();

              // Valida os campos de dedução, aliquota e valida as regras dos valores
              validaRegraCalculoServico(data);
            }
          } else {

            fieldSetValoresServico.find('input, select, textarea').attr('readonly', true);
            fieldSetValoresServico.attr('disabled', true);
          }

          regraCooperado();
        }
      });
    }
  });
  /**
   * Alteração do município
   */
  municipioServico.change(function() {

    naturezaOperacao.val('1');
    validaRegraEmissao();
  });
  /**
   * Verifica regra da tributação ao selecionar a natureza da operação
   */
  naturezaOperacao.change(function() {

    // Feito essa validação apenas para garantir quando o serviço for de alíquota fixada e o contribuinte selecionar fora do munícipio
    if ($("div.input-append span.add-on").text() !== 'FIXADA' && $(this).val() == '1') {
      servico.change();
    }

    if($("#t_cooperado option:selected").val() == 'true' && regimeTributario.val() == 15){
      servico.change();
    }else{
      validaRegraEmissao();
    }
  });

  /**
   * Adicionar validação cpf/cnpj
   *   msg e limpar campo
   */
  $('#t_cnpjcpf').cpfcnpj({
     validate: 'cpfcnpj',
     event: 'blur',
     handler:'input#t_cnpjcpf',
     ifValid:   function () { },
     ifInvalid: function () {

       bootbox.alert('Campo CPF / CNPJ inválido.');
      $('#t_cnpjcpf').val(null);
     }
  });

  /**
  * Busca Tomador
  */
  cnpjCpfTomador.buscador({
    'statusInput' : 'input#t_razao_social',
    'url'         : cnpjCpfTomador.attr('url'),
    'data'        : { 'substituto': $('#substituto_tributario') },
    'success'     : function(data) {

      if (data) {

        if (data.success == false) {

          $('#t_cnpjcpf').val(null);
          bootbox.alert(data.message);

        } else {

          if (!data.uf) {
            data = data[0];
          }

          var estado = $('#t_uf');
          if (data.uf) {

            estado.val(data.uf);
            estado.change();
          }

          var municipio = $('#t_cod_municipio');
          if (data.cod_ibge) {

            municipio.val(data.cod_ibge);
            municipio.change();
          }

          if (data.endereco) {
            $('#t_endereco').val(data.endereco);
          }

          // Verifica se o tomador é substituto tributário e do municipio
          verificaTomadorMunicipio(data);

          $.each(data, function(campo, valor) {
            if ($('[campo-ref=' + campo + ']')) {
              $('[campo-ref=' + campo + ']').val(valor);
            }
          });
        }
      }

      // Reprocessa as máscaras no campos
      $().addMascarasCampos();

      // Valida regra de emissão
      validaRegraEmissao();

      // Posiciona o foco no campo de email
      $('#t_email').focus();
    },
    'not_found'   : limpaDadosTomador()
  });
  /**
  * Abre/Fecha Legends
  */
  lblLegenda.click(function() {
    $(this).find('~ *').each(function(i, div) {
      $(div).toggle();
    });
  });
  /**
  * Seta no campo hidden a flag de iss_retido
  */
  issRetido.change(function () {
    $('#s_dados_iss_retido').val($(this).val());
    lstCalculoTotal.change();
  });
  /**
  * Bloqueia tela no submit do formulario
  */
  btnEmitir.click(function(e) {

    e.preventDefault();
    verificaPreenchimentoFormulario();

    // Verifica se está faltando preencher algum campo
    if ($('fieldset').hasClass('validation-cancel')) {
      return false;
    }

    // Valida se o botão está desabilitado, pois uma nota está em processamento
    if ($('#emitir').is('[disabled=disabled]')) {
      return false;
    }

    var form = $(this).closest('form');
    form.find('input, select, textarea').attr('readonly', true);
    btnEmitir.html('Aguarde...').attr('disabled', true);

    $.post(form.attr('action'), form.serialize(), function(data) {

      if (data) {

        if (data.status) {

          bootbox.alert(data.messages[0].success);
          $(location).attr('href', data.url);
        } else {

          form.find('input, select, textarea').attr('readonly', false);
          btnEmitir.html('Emitir').attr('disabled', false);

          var errors = '<b>Erros encontrados!</b><br />';
          $.each(data.messages, function(indice, data) {
            errors = errors + data.error + '<br /> ';
          });

          bootbox.alert(errors);
          servico.change();
          $('#s_vl_liquido').attr('readonly', true);
          $('#s_vl_iss').attr('readonly', true);
          $('#s_vl_bc').attr('readonly', true);
        }
      }
    });
  });
  /**
  * Previne submit ao pressionar 'Enter'
  */
  lstEvitarEnter.keypress(function(e) {
    if (e.which == 13) {
      e.preventDefault();
    }
  });

  paisServico.change( function(){

    if (paisServico.val() != CODIGO_BRASIL) {

      $('#estado').val(0).closest('.control-group').hide();
      $('#s_dados_municipio_incidencia').val(0).closest('.control-group').hide();
      $('#estado').change();
      $('#s_dados_cidade_estado').val('').closest('.control-group').show();

      if ( $("#b_mei_sociedade_profissionais").val() == 0 ) {
        $('#s_dados_fora_incide').val(1).attr('readonly', false).attr('disabled', false);
      } else {
        $('#s_dados_fora_incide').val(0).attr('readonly', true).attr('disabled', true);
      }

    } else {

      $("#s_dados_fora_incide").val(1);
      $('#s_dados_cidade_estado').val('').closest('.control-group').hide();
      $('#estado').val(0).closest('.control-group').show();
      $('#s_dados_municipio_incidencia').val(0).closest('.control-group').show();

      if ( $("#b_mei_sociedade_profissionais").val() == 0 ) {
        $('#s_dados_fora_incide').val(1).attr('readonly', true).attr('disabled', true);
      } else {
        $('#s_dados_fora_incide').val(0).attr('readonly', true).attr('disabled', true);
      }

    }

    servico.change();
  });

  paisTomador.change( function(){

      if (paisTomador.val() != CODIGO_BRASIL) {

        $('#t_uf').val(0).closest('.control-group').hide();
        $('#t_cod_municipio').val(0).closest('.control-group').hide();
        $('#t_uf').change();
        $('#t_cidade_estado').val('').closest('.control-group').show();

        if ( $("#b_mei_sociedade_profissionais").val() == 0 ) {
          $('#s_dados_fora_incide').val(1).attr('readonly', false).attr('disabled', false);
        } else {
          $('#s_dados_fora_incide').val(0).attr('readonly', true).attr('disabled', true);
        }

      } else {

        $("#s_dados_fora_incide").val(1);
        $('#t_cidade_estado').val('').closest('.control-group').hide();
        $('#t_uf').val(0).closest('.control-group').show();
        $('#t_cod_municipio').val(0).closest('.control-group').show();

        if ( $("#b_mei_sociedade_profissionais").val() == 0 ) {
          $('#s_dados_fora_incide').val(1).attr('readonly', true).attr('disabled', true);
        } else {
          $('#s_dados_fora_incide').val(0).attr('readonly', true).attr('disabled', true);
        }

      }

      servico.change();
  });

  $('#s_dados_fora_incide').change(function(){

    if ($('#s_dados_fora_incide').val() == 0) {

      $("div.input-append span.add-on").text('NÃO INCIDE');
      $('#s_iss_retido').val(0);
      $('#s_vl_iss').val(0.00);
      $('#s_vl_aliquota').val(0).hide();
    } else {
      $('#s_dados_cod_tributacao').change();
      $("div.input-append span.add-on").text('%');
      $('#s_vl_aliquota').show();
    }
  });

  fieldSetValoresServico.find('input, select, textarea').attr('readonly', true);
  $('#s_dados_cidade_estado').closest('.control-group').hide();
  $('#t_cidade_estado').closest('.control-group').hide();
  $('#s_dados_fora_incide').attr('readonly', true).attr('disabled', true).val(1);
  fieldSetValoresServico.attr('disabled', true);
  notaSubstituta.change();
  dataNota.change();
  limpaDadosTomador();
  window.setTimeout(buscaDadosNota, 2000);
});