$(function() {
  $('#Cadastrar-element').hide();
  $('#Cadastrar-label').hide();
  
  // Adiciona mascaras nos campos
  $().addMascarasCampos();
  
  // Submit do formulário da modal
  $('#formEmpresa').submit(function(e) {
    var action     = $(this).attr('action');
    var z01_cgccpf = $('#z01_cgccpf').val();
    
    $.ajax({
      type        : 'post',
      data        : $(this).serialize(),
      url         : action,
      error       : function(data) { $('#myModal').html(data.responseText); },
      success     : function(data) {
        $.ajax({
          url     : '/contribuinte/empresa/dados-cgm',
          data    : { 'term' : z01_cgccpf },
          success : function(data2) {
            if (data2) {
              
              data2 = data2[0];
              
              // Usado na tela de emissao de nota no DMS
              $('#s_inscricao_municipal').val(data2.inscricao);
              $('#s_razao_social').val(data2.nome);
              $('#s_cpf_cnpj').val(data2.cpf);
              $('#s_cpf_cnpj').blur();
              
              // Usado na tela de emissao de nota eletronica
              $('#t_cnpjcpf').val(data2.cpf);
              $('#buscador').click();
              
              $().addMascarasCampos();
            }
          }
        });
        
        $('#myModal').modal('hide');
      }
    });
    
    e.preventDefault();
  });
  
  // Salvar, executa o submit do form
  $('#enviaEmpresa').click(function(e) {    
    $('#formEmpresa').submit();
  });
  
  // Troca de estado, carrega os municipios
  $('#z01_uf').change(function(e) {
    var estado          = $(this).val();
    var id_select_munic = $(this).attr('select-munic');
    var myurl           = $(this).attr('ajax-url');
    var select_munic    = $('#' +id_select_munic);
    var haskey          = select_munic.attr('key');
    
    if (estado != '0') {
      
      $.ajax({
        url     : myurl,
        data    : 'uf=' +estado,
        context : this,
        async   : false,
        success : function(data) {
          select_munic.html('');
          
          $.each(data, function(key, val) {
            if (val != null) {
              select_munic.append('<option value="' +(haskey ? key : val)+ '">' +val+ '</option>');
            }
          });
        }
      });
    } else {
      select_munic.html('');
    }
    
    $('#z01_munic').change();
  });
  
  // Troca de municipio
  $('#z01_munic').change(function() {
    
    // Se escolhido o municipio em atividade, lista os bairros do mesmo
    if ($(this).val() == $('#z01_bairro_munic').attr('municipio')) {
      
      $('#z01_bairro_munic').parent().parent().show();
      $('#z01_ender_munic').parent().parent().show();
      $('#z01_bairro_fora').parent().parent().hide();
      $('#z01_ender_fora').parent().parent().hide();
      $('#endereco_fora').val('0');
    } else {
      
      $('#z01_bairro_munic').parent().parent().hide();
      $('#z01_ender_munic').parent().parent().hide();
      $('#z01_bairro_fora').parent().parent().show();
      $('#z01_ender_fora').parent().parent().show();
      $('#endereco_fora').val('1');
      $('#z01_bairro_fora').val('');
      $('#z01_ender_fora').val('');
    }
  });
  $('#z01_munic').change();
  
  // Grava o endereco no campo input para salvar o texto ao inves do codigo
  $('#z01_ender_munic').change(function(e) {
    $('#z01_ender_fora').val($('#z01_ender_munic option:selected').html());  
  });
  
  // Grava o bairro no campo input para salvar o texto ao inves do codigo
  $('#z01_bairro_munic').change(function(e) {
    $('#z01_bairro_fora').val($('#z01_bairro_munic option:selected').html());  
  });
});