(function($) {

  /**
   * Retorna somente numeros
   */
  $.fn.returnNumbers = function(str) {
    str = str.toString();

    return str.replace(/[^\d]+/g, '');
  };

  /**
   * Retorna valores em formato da moeda brasileira
   *
   * @example
   *   $().number_format('99,999.99', 2, ',', '.'); // Retorna: '99.999,99'
   */
  $.fn.number_format = function(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    var s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }

    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }

    return s.join(dec);
  };

  /**
   * Auto complete
   */
  $.fn.autoComplete = function(myurl, myFunction) {
    $(this).autocomplete({
      select: function(event, ui) {
        myFunction(ui.item.id);
      },
      source: function(request, response) {
        var term = request.term;
        $.ajax({
          url    : myurl + '/term/' + term,
          success: function(data) {
            data = JSON.parse(data);
            response($.map(data, function(item, i) {
              return { label: item, value: item, id: i };
            }));
          }
        });
      }
    });
  };

  /**
   * Reseta o formulario
   */
  $.fn.formReset = function(options) {
    var settings = $.extend({'form': $(this) }, options);

    settings.form.each(function() {
      this.reset();
    });
  };

  /**
   * Processa o formulario do elemento via ajax, retornando erros (html) no fieldset pai do elemento
   *
   * @namespace error.exception
   * @namespace data.fields
   * @params eThis              Elemento, geralmente Submit do Form
   * @params eForm              Formulario
   * @params eMessageContainer  Elemento onde serao exibidos os erros
   * @params eMessage           Elemento dinamico com as mensagens de retorno
   * @params beforeSendCallback Funcao de retorno executada somente se o script for processado com sucesso
   * @params completeCallback   Funcao de retorno executada ao completar o processo
   * @params errorCallback      Funcao de retorno executada somente se o script for processado com erros
   * @addon  bootbox            Utilizado para estilizar "alert" e "confirm" (http://bootboxjs.com/)
   * @returns object (this)
   */
  $.fn.submitForm = function(options) {
    var $eThis = $(this);
    var settings = $.extend({
      'eThis'             : $(this),
      'eForm'             : $(this).closest('form'),
      'eMessageContainer' : '',
      'eMessage'          : $('.ajax-message'),
      'beforeSendCallback': function() {
        $eThis.attr('disabled', true);
      },
      'completeCallback'  : function() {
        $eThis.attr('disabled', false);
      },
      'errorCallback'     : function(xhr) {

        if (xhr.responseText) {

          var error = $.parseJSON($.trim(xhr.responseText));

          bootbox.alert(error.message);

          if (error.exception) {
            console.log(error.exception);
          }
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!<br>readyState: ' + xhr.readyState + '<br>status: ' + xhr.status);
        }

        $eThis.attr('disabled', false);
      }
    }, options);

    // Remove mensagem com erros
    settings.eMessage.remove();

    $.ajax({
      dataType  : 'json',
      type      : (settings.eForm.attr('method') == '' ? 'GET' : settings.eForm.attr('method')),
      url       : settings.eForm.attr('action'),
      data      : settings.eForm.serialize(),
      success   : function(data) {

        settings.eForm.find('.control-group').removeClass('error'); // Retira a classe de erros

        if (data.status) {

          if (data.success && typeof settings.successCallback == 'function') {
            settings.successCallback.call(this, data);
          } else if (data.success && data.reload == true) {
            bootbox.alert(data.success, function() {
              location.reload();
            });
          } else if (data.success && data.url) {
            bootbox.alert(data.success, function() {
              location.href = data.url;
            });
          } else if (data.success) {
            bootbox.alert(data.success);
          } else if (data.url) {
            location.href = data.url;
          }
        } else if (data.error) {

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

          if (settings.eMessageContainer) {
            settings.eMessageContainer.html(sMessage);
          } else {
            settings.eThis.closest('fieldset').before(sMessage);
          }
        } else {
          bootbox.alert('Ocorreu um erro desconhecido!');
        }
      },
      beforeSend: settings.beforeSendCallback,
      error     : settings.errorCallback,
      complete  : settings.completeCallback
    });

    return this;
  };

  /**
   * Carrega conteudo Html em um elemento alvo via ajax
   *
   * @param options
   * @param options.target   Elemento alvo, que recebera o html
   * @param options.url      Url de processamento do html
   * @param options.loading  Mensagem mostrando enquando aguardo o processamento
   * @param callback         Função a ser executada após o processamento
   * @returns object (this)
   */
  $.fn.loadHtml = function(options, callback) {
    var settings = $.extend({
      'target' : $(this),
      'url'    : '',
      'loading': '<div class="alert alert-info">Carregando...</div>'
    }, options);

    if (settings.target.data('loading')) {
      settings.loading = '<div class="alert alert-info">' + settings.target.data('loading') + '</div>';
    }

    $.ajax({
      url       : settings.url,
      error     : function(xhr) {
        settings.target.html('Erro ao processar!<br>readyState: ' + xhr.readyState + '<br>status: ' + xhr.status);
      },
      beforeSend: function() {
        settings.target.html(settings.loading);
      },
      success   : function(data) {
        settings.target.html(data);
      },
      complete  : function() {

        // Executa a funcao callback
        if (typeof callback == 'function') {
          callback.call(this);
        }
      }
    });

    return this;
  };

  /**
   * Calcula valores DMS
   *
   * @param options
   * @param options.url   Url para processar a requisicao ajax, deve retornar um json
   * @param options.oThis Elemento alvo, geralmente o botao submit do form
   * @param options.oForm Formulario onde os parametros serao enviados
   * @param callback      Função a ser executada após o processamento
   * @returns object (this)
   */
  $.fn.calculaValoresDms = function(options, callback) {
    var oJsonValoresCalculados = null; // Valores calculados, retornados pelo servidor
    var settings = $.extend({
      'url'  : '',
      'oThis': $(this),
      'oForm': $(this).closest('form')
    }, options);

    $.ajax({
      dataType: 'json',
      url     : settings.url,
      data    : settings.oForm.serialize(),
      async   : false,
      error   : function(xhr) {
        bootbox.alert('Ocorreu um erro ao processar!<br>readyState: ' + xhr.readyState + '<br>status: ' + xhr.status);
      },
      success : function(data) {
        if (data) {
          oJsonValoresCalculados = data;
        } else {
          bootbox.alert('Ocorreu um erro ao recuperar valores do serviço');
        }
      }
    });

    // Executa a funcao callback
    if (typeof callback == 'function') {
      callback.call(this, oJsonValoresCalculados);
    }

    return this;
  };

  /**
   * Buscador via ajax
   *
   * @param options
   * @param options.statusInput
   * @param options.success
   * @param options.preSearch
   * @param options.complete
   * @param options.not_found
   * @returns object (this)
   */
  $.fn.buscador = function(options) {
    var input_busca = $(this);
    var input_resultado = $(options.statusInput);
    var botao_busca = $(this).find('~ button#buscador');
    var success_callback = options.success;
    var pre_search = options.preSearch;
    var post_search = options.complete;
    var not_found_callback = options.not_found;
    var data = !options.data ? null : options.data;
    var url = $(this).attr('url-buscador');

    if (!url) {
      url = options.url;
    }

    function resultado_msg(msg) {

      if (input_resultado.is('input')) {
        input_resultado.val('').attr('placeholder', msg);
      } else if (input_resultado.is('span')) {
        input_resultado.text(msg);
      } else {
        input_resultado.html(msg);
      }
    }

    input_busca.keydown(function(e) {
      if (e.which == 13) {

        e.preventDefault();
        botao_busca.click();
      }
    });

    botao_busca.click(function(e) {
      e.preventDefault();

      var query = input_busca.val();

      botao_busca.find('i').removeClass('icon-search');
      botao_busca.find('i').addClass('icon-repeat');

      resultado_msg('Aguarde...');

      var data_string = '&';

      if (data) {

        $.each(data, function(k, v) {

          if (v.attr('type') === 'checkbox') {
            data_string += k + '=' + !!v.attr('checked');
          }
        });
      }

      if (pre_search) {
        pre_search();
      }

      $.ajax({
        url     : url,
        data    : 'term=' + query + data_string,
        success : function(data) {
          //data = JSON.parse(data);

          if (data != null) {

            resultado_msg('Não encontrado');
            success_callback(data);
          } else {

            resultado_msg('Não encontrado');

            if (not_found_callback) {
              not_found_callback();
            }
          }
        },
        complete: function(data, status) {
          var msg = '';

          switch (status) {
            case 'timeout'     :
              msg = 'Erro na comunicação.';
              break;
            case 'error'       :
              msg = 'Erro interno de servidor.';
              break;
            case 'parsererror' :
              msg = 'Erro ao interpretar resposta.';
              break;
          }

          if (msg != '') {
            resultado_msg(msg);
          }

          botao_busca.find('i').removeClass('icon-repeat');
          botao_busca.find('i').addClass('icon-search');

          if (post_search) {
            post_search(data, status);
          }
        }
      });
    });

    return this;
  };

  /**
   * Adiciona mascaras nos elementos
   *
   * @returns object (this)
   */
  $.fn.addMascarasCampos = function() {
    var currentTime = new Date();
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 0, +1);
    var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 1, +0);

    $('.mask-cep').setMask('cep');
    $('.mask-data').setMask('date').datepicker();
    $(".mask-data-dias-mes-corrente").setMask('date').datepicker({ minDate: minDate, maxDate: maxDate });
    $('.mask-porcentagem').setMask({ 'mask': '99,99', 'type': 'reverse' });
    $('.mask-cpf').setMask({ 'mask': '999.999.999-99' });
    $('.mask-cnpj').setMask({ 'mask': '99.999.999/9999-99' });
    $('.mask-competencia').setMask({ 'mask': '99/9999' });
    $('.mask-valores').setMask({
      'mask'     : '99,999.999.9',
      'type'     : 'reverse',
      'maxlength': ($(this).attr('maxlength') ? $(this).attr('maxlength') : 11)
    });
    $('.mask-numero').setMask({
      'mask'     : '9',
      'type'     : 'repeat',
      'maxlength': ($(this).attr('maxlength') ? $(this).attr('maxlength') : -1)
    });

    $('.mask-fone').keyup(function() {
      var phone, element;

      element = $(this);
      element.unsetMask();
      phone = element.val().replace(/\D/g, '');

      if (phone.length > 10) {
        element.setMask('(99) 999-999-999?9');
      } else {
        element.setMask('(99) 9999-99999?9');
      }
    }).trigger('keyup');

    $('.mask-cpf-cnpj').keyup(function() {
      var number, element;

      element = $(this);
      element.unsetMask();
      number = element.val().replace(/\D/g, '');

      if (number.length > 11) {
        element.setMask('99.999.999/9999-99?9');
      } else {
        element.setMask('999.999.999-999?9');
      }
    }).trigger('keyup');

    return this;
  };

  /**
   * Função genérica para buscar os dados por ajax e carregar em um elemento alvo
   *
   * Pode ser setado os atributos diretamente no elemento com o prefixo "ajax"
   *
   * @param options.url         Link para requisicao ajax
   * @param options.target      Elemento alvo que recebera as informacoes retornadas
   * @param options.data        Dados enviados por parametro. Formato: { 'param1' : 'valor_param1' }
   * @param options.beforeSend  Funcao para ser executada antes do processamento (beforeSend
   * @param options.done        Funcao para ser executada quando o processamento e executado com sucesso (success)
   * @param options.fail        Funcao para ser executada quando ocorrem erros no processamento (error)
   * @param options.always      Funcao para ser executada ao final do processamento (complete)
   * @returns object (this)
   */
  $.fn.ajaxSelect = function(options) {
    var $this = $(this);
    var settings = $.extend({
      'url'       : $this.attr('ajax-url'),
      'target'    : $($this.attr('ajax-target')),
      'data'      : {},
      'beforeSend': function(xhr) {
      },
      'done'      : false,
      'fail'      : false,
      'always'    : false
    }, options);

    if ($this.attr('ajax-param')) {
      settings.data[$this.attr('ajax-param')] = $this.val();
    }

    // Limpa o elemento alvo
    settings.target.html('');

    // Executa a busca de dados
    var ajax = $.ajax({
      url       : settings.url,
      data      : settings.data,
      beforeSend: function(xhr) {
        settings.beforeSend(xhr);
      }
    });

    /**
     * Executa funcoes enviadas por parametro ou executa a padrao
     */
    // Equivale a success
    if (typeof settings.done === 'function') {
      ajax.done(settings.done);
    } else {

      // Padrao se nao enviada nenhuma funcao por parametro
      ajax.done(function(data) {

        if (data) {

          $.each(data, function(indice, valor) {

            if (valor) {
              settings.target.append('<option value="' + indice + '">' + valor + '</option>');
            }
          });
        }
      });
    }

    // Equivale a "complete"
    if (typeof settings.always === 'function') {
      ajax.always(settings.always);
    }

    // Equivale a "error"
    if (typeof settings.fail === 'function') {
      ajax.fail(settings.fail);
    }

    return $this;
  };

  /**
   * Exibe uma div com CSS no padrão Twitter Bootstrap
   *
   * @param options.mensagem
   * @param options.tipo
   */
  $.fn.mostrarDivErro = function(options) {

    var $this = $(this);
    var settings = $.extend({
      'mensagem': '',
      'tipo'    : 'error'
    }, options);

    var sDivMessagem = '<div class="alert alert-' + settings.tipo + ' ajax-message"> ' +
      '  <button type="button" class="close" data-dismiss="alert">×</button>' + settings.mensagem +
      '</div>';
    $this.html(sDivMessagem);
  };

  /**
   * Adiciona um contador em todas as textareas que possuam a classe "exibir-contador-maxlength"
   *
   * @param options
   * @param options.jquery_element elemento_alvo [Exemplo: $('#id'), $('.classe'), etc..]
   * @param options.numero_caracteres
   */
  $.fn.adicionarNumeroCaracteresTextArea = function(options) {

    var settings = $.extend({
      'elemento_alvo'    : $('.exibir-contador-maxlength'),
      'numero_caracteres': '2000'
    }, options);

    // Varre todas os elementos
    settings.elemento_alvo.each(function(id, oTextArea) {

      var oParenteNode = oTextArea.parentNode;
      var oDivContador = document.createElement('div');
      oDivContador.id = 'div_contador_textarea_' + oTextArea.id;
      oDivContador.className = 'div_contador_textarea';

      if (oTextArea.getAttribute('maxlength') == null || oTextArea.getAttribute('maxlength') == '') {
        oTextArea.setAttribute('maxlength', settings.numero_caracteres);
      }

      var iLimiteCaracteres = oTextArea.getAttribute('maxlength');
      var sContadorConteudo = '<span id="div_contador_textarea_span' + oTextArea.id + '">0</span>';

      oDivContador.innerHTML = 'Caracteres: ' + sContadorConteudo + ' / ' + iLimiteCaracteres;
      oParenteNode.appendChild(oDivContador);

      $(oTextArea).keyup(function() {

        var sTexto       = $(this).val();
        var iTotalLetras = (sTexto.length + sTexto.split('\\n').length) - 1;

        $('#div_contador_textarea_span' + $(this).attr('id')).html(iTotalLetras);
      });
    });
  };

  /**
   * Método de controle de erros das requisições ajax
   *
   * @param data json
   * @param $oFieldsets object form fields
   */
  $.fn.bloqueiaEmissao = function(data, $oFieldsets) {

  	$oFieldsets.find('input').attr('disabled', true);
    $oFieldsets.find('select').attr('disabled', true);
    $oFieldsets.find('textarea').attr('disabled', true);
    $oFieldsets.find('button').attr('disabled', true);

    // Bloqueio do formulário
    $('form input, form select, form textarea, form button').attr('readonly', true);
    $('form input, form select, form textarea, form button').attr('disabled', true);

    if (data.responseText) {

      var error = $.parseJSON($.trim(data.responseText));
      var msg   = error.message;

      if (error.exception) {
      	msg = error.exception.information;

      }
      bootbox.alert(msg);

      if (error.exception) {
        console.log(error.exception);
      }
    } else {
    	if (data.mensagem) {
    		bootbox.alert(data.mensagem);
    	}
    }
  };

  /**
   * Monta uma grid simples de consulta de dados utilizando a jqGrid
   * @param object options
   * @constructor
   */
  $.fn.DBJqGrid = function (options) {

    var $oJqGrid = $('#jqList');
    $oJqGrid.jqGrid({
      url            : (options.url) ? options.url : '',
      height         : 230,
      datatype       : 'json',
      mtype          : 'POST',
      colNames       : (options.colNames) ? options.colNames : [],
      colModel       : (options.colModel) ? options.colModel : [],
      postData       : (options.postData) ? options.postData : {},
      rowNum         : 10,
      rowList        : [10, 20, 30],
      pager          : '#jqPager',
      viewrecords    : true,
      autowidth      : true,
      sortname       : (options.sortname) ? options.sortname : '',
      sortorder      : (options.sortorder) ? options.sortorder : '',
      ondblClickRow  : (options.ondblClickRow) ? options.ondblClickRow : function () {},
      onSelectRow    : (options.onSelectRow) ? options.onSelectRow : function () {},
      onCellSelect   : (options.onCellSelect) ? options.onCellSelect : function () {},
      afterInsertRow : (options.afterInsertRow) ? options.afterInsertRow : function () {},
      loadComplete   : (options.loadComplete) ? options.loadComplete : function () {}
    });

    $oJqGrid.jqGrid('setGridWidth', $("#jqGridContainer").width(), true);
    $oJqGrid.jqGrid('navGrid', '#jqPager', {edit: false, add: false, del: false, search: false});
    $oJqGrid.jqGrid("setGridParam", {
      datatype: "json",
      postData: (options.postData) ? options.postData : {}
    }).trigger("reloadGrid", [
        {current: true, page: 1}
    ]);

    return $oJqGrid;
  };

  /**
   * Serializa o forme em um ArrayObject
   * @returns {{}}
   */
  $.fn.serializeObject = function () {

    var $oFields = {};
    var $aFields = this.serializeArray();

    $.each($aFields, function () {

      if ($oFields[this.name] !== undefined) {

        if (!$oFields[this.name].push) {
          $oFields[this.name] = [$oFields[this.name]];
        }

        $oFields[this.name].push(this.value || '');
      } else {
        $oFields[this.name] = this.value || '';
      }
    });

    return $oFields;
  };

  /**
   * Validar CPF/CNPJ
   */
    $.fn.cpfcnpj = function (options) {

        var settings = $.extend({
            mask: false,
            validate: 'cpfcnpj',
            event: 'focusout',
            handler: $(this),
            ifValid: null,
            ifInvalid: null
        }, options);

        if (settings.mask) {
            if (jQuery().mask == null) {
                settings.mask = false;
            }
            else {
                if (settings.validate == 'cpf') {
                    $(this).mask('000.000.000-00');
                }
                else if (settings.validate == 'cnpj') {
                    $(this).mask('00.000.000/0000-00');
                }
                else {
                    var ctrl = $(this);
                    var opt = {
                        onKeyPress: function (field) {
                            var masks = ['000.000.000-009', '00.000.000/0000-00'];
                            msk = (field.length > 14) ? masks[1] : masks[0];
                            ctrl.mask(msk, this);
                        }
                    };

                    $(this).mask('000.000.000-009', opt);
                }
            }

        }

        return this.each(function () {
            var valid = null;
            var control = $(this);

            $(document).on(settings.event, settings.handler,
               function () {

                   if (control.val().length == 14 || control.val().length == 18) {

                       if (settings.validate == 'cpf') {
                           valid = validate_cpf(control.val());
                       }
                       else if (settings.validate == 'cnpj') {
                           valid = validate_cnpj(control.val())
                       }
                       else if (settings.validate == 'cpfcnpj') {

                           if (validate_cpf(control.val())) {

                               valid = true;
                               type = 'cpf';
                           }
                           else if (validate_cnpj(control.val())) {

                               valid = true;
                               type = 'cnpj';
                           }
                           else valid = false;
                       }
                   } else{

                     if(control.val().length == 0){
                      return;
                     }
                     valid = false;
                   }

                   if (typeof(settings.ifValid) == 'function') {

                       if (valid != null && valid) {
                           if ($.isFunction(settings.ifValid)) {
                               var callbacks = $.Callbacks();
                               callbacks.add(settings.ifValid);
                               callbacks.fire(control);
                           }
                       }
                       else if (typeof(settings.ifInvalid) == 'function') {
                           settings.ifInvalid(control);
                       }
                   }
               });
        });

        function validate_cnpj(val) {

          if (val.match(/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/) != null) {
              var val1 = val.substring(0, 2);
              var val2 = val.substring(3, 6);
              var val3 = val.substring(7, 10);
              var val4 = val.substring(11, 15);
              var val5 = val.substring(16, 18);

              var i;
              var number;
              var result = true;

              number = (val1 + val2 + val3 + val4 + val5);

              s = number;

              c = s.substr(0, 12);
              var dv = s.substr(12, 2);
              var d1 = 0;

              for (i = 0; i < 12; i++)
                  d1 += c.charAt(11 - i) * (2 + (i % 8));

              if (d1 == 0)
                  result = false;

              d1 = 11 - (d1 % 11);

              if (d1 > 9) d1 = 0;

              if (dv.charAt(0) != d1)
                  result = false;

              d1 *= 2;
              for (i = 0; i < 12; i++) {
                  d1 += c.charAt(11 - i) * (2 + ((i + 1) % 8));
              }

              d1 = 11 - (d1 % 11);
              if (d1 > 9) d1 = 0;

              if (dv.charAt(1) != d1)
                  result = false;

              return result;
          }
          return false;
        }

        function validate_cpf(val) {

          if (val.match(/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/) != null) {
              var val1 = val.substring(0, 3);
              var val2 = val.substring(4, 7);
              var val3 = val.substring(8, 11);
              var val4 = val.substring(12, 14);

              var i;
              var number;
              var result = true;

              number = (val1 + val2 + val3 + val4);

              s = number;
              c = s.substr(0, 9);
              var dv = s.substr(9, 2);
              var d1 = 0;

              for (i = 0; i < 9; i++) {
                  d1 += c.charAt(i) * (10 - i);
              }

              if (d1 == 0)
                  result = false;

              d1 = 11 - (d1 % 11);
              if (d1 > 9) d1 = 0;

              if (dv.charAt(0) != d1)
                  result = false;

              d1 *= 2;
              for (i = 0; i < 9; i++) {
                  d1 += c.charAt(i) * (11 - i);
              }

              d1 = 11 - (d1 % 11);
              if (d1 > 9) d1 = 0;

              if (dv.charAt(1) != d1)
                  result = false;

              return result;
          }

          return false;
        }
    }

}(jQuery));