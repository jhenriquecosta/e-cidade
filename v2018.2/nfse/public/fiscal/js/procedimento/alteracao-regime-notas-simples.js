$(function() {

  var iValIdUsuario = $('#id_usuario option:selected').val();

  $('#id_usuario').combobox();
  $('input[name="id_usuario"]').val(iValIdUsuario);
  // Desabilita o botao processar
  $('#btn_processar').prop("disabled", true);
  $('div #cadastro-simples').addClass('hidden');
  $('div #retorno-processamento').addClass('hidden');

  // Consulta o cadastro do simples nacional do contribuinte
  $('#btn_consultar').click(function (e) {

    if (!$('#id_usuario').val()) {
      return false;
    }

    $('#btn_processar').prop("disabled", true);
    $("div #alert").addClass('hidden');
    consultaCadastroSimplesNacional(this);

    e.preventDefault();
    return false;
  });


  // Processa alteracao
  $('#btn_processar').click(function(e){

    params = this;

    bootbox.confirm("Tem certeza que deseja processar está alteração?", function (bReturn) {
      if (bReturn) {
        $('#btn_processar').prop("disabled", true);
        processarAlteracaoNotas(params);
       }
    });

    e.preventDefault();
    return false;
  });

  function consultaCadastroSimplesNacional(params) {

    dataContainer = $('div #cadastro-simples tbody');
    $('div #cadastro-simples').addClass('hidden');
    $('div #retorno-processamento').addClass('hidden');
    sAction = '/fiscal/procedimento/consulta-cadastro-simples-nacional-usuario';
    var form = $(params).closest('form');

    $.post(sAction, form.serialize(), function(data) {

      if (data) {

        if (data.status) {
          if (data.messages) {
            alert = '';
            $.each(data.messages, function(indice, data) {
              alert = alert + '<span class"alert">' + data + '</span><br />';
            });
            bootbox.alert(alert);
            $('div #cadastro-simples').addClass('hidden');
            return false;
          }

          if (data.dados) {

            dataContainer.empty();

            $.each(data.dados, function(indice, data) {
              sLinha = '<tr><td class="text-center db-consulta-coluna01">' + data.data_inicial + '</td>';
              sLinha = sLinha + '<td class="text-center db-consulta-coluna02">' + data.data_baixa + '</td>';
              sLinha = sLinha + '<td class="text-center db-consulta-coluna03">' + data.categoria + '</td></tr>';
              dataContainer.append(sLinha);
            });
            $('#btn_processar').prop("disabled", false);
            $('div #cadastro-simples').removeClass('hidden');
            return;
          }
        } else {

          var errors = '<b>Erros encontrados!</b><br />';
          $.each(data.messages, function(indice, data) {
            errors = errors + data + '<br /> ';
          });
          bootbox.alert(errors);
        }
      }
    });

  }


  //  Processa as alteracoes
  function processarAlteracaoNotas(params) {


    // Valida se o botão está desabilitado, pois uma nota está em processamento
    if ($('#btn_processar').is('[disabled=disabled]')) {
      return false;
    }
    $('div #retorno-processamento').addClass('hidden');
    dataContainer = $('div #retorno-processamento tbody');

    sAction = '/fiscal/procedimento/processa-alteracao-regime-notas-simples';

    $("div #alert").removeClass('hidden').html('<span>Processando... <br/> Pode demorar alguns minutos, dependendo da quantidade de notas</span>');

    var form = $(params).closest('form');


    $.post(sAction, form.serialize(), function(data) {
      if (data) {
        if (data.status) {
          alert = '';
          $.each(data.messages, function(indice, data) {
            alert = alert + '<span class"alert">' + data + '</span><br />';
          });

          if (data.dados) {

            dataContainer.empty();
            if (data.dados.inconsistencias) {

              notasinconsistentes = '<span class"alert">';
              quantidade_inconsistencias = (data.dados.inconsistencias.length -1);

              $.each(data.dados.inconsistencias, function(indice, data) {
                notasinconsistentes = notasinconsistentes + data + ((indice > 0 && quantidade_inconsistencias != indice) ? ', ' : ' ');
              });

              notasinconsistentes = notasinconsistentes + '</span><br />';

            }
            alert = alert + notasinconsistentes;

            $.each(data.dados.competencias, function(indice, data) {
              sLinha = '<tr><td class="text-center db-consulta-coluna01">' + data.mes_comp + ' / ' + data.ano_comp + '</td></tr>';
              dataContainer.append(sLinha);
            });
            $('div #retorno-processamento').removeClass('hidden');
            $("div #alert").addClass('hidden').empty();

          }

          /* Alerta */
          bootbox.alert(alert);
          return;
        } else {

          var errors = '<b>Erros encontrados!</b><br />';
          $("div #alert").addClass('hidden').empty();
          $('div #retorno-processamento').addClass('hidden');
          $.each(data.messages, function(indice, data) {
            errors = errors + data + '<br /> ';
          });
          bootbox.alert(errors);
        }
      }
    });


  }

});
