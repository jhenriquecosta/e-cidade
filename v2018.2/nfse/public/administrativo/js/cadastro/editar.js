$(function() {
  var $elmUf            = $('#estado');
  var $elmCidade        = $('#cidade');
  var $elmBairro        = $('#cod_bairro');
  var $elmBairroTexto   = $('#bairro');
  var $elmEndereco      = $('#cod_endereco');
  var $elmEnderecoTexto = $('#endereco');
  var $elmsOcultos      = $('.campo-oculto');
  
  // Oculta campos
  $elmsOcultos.parent().parent().hide();
  
  // Mostra Cidades por Estados  
  $elmUf.change(function(e) {
    
    var $this = $(this);
    
    $.ajax({
      url     : $this.attr('ajax-url'),
      data    : $this.attr('campo-ref') + '=' + $this.val(),
      context : this,
      async   : false,
      success : function(data) {
        data = JSON.parse(data);
        
        $elmCidade.html('<option value=""></option>');
        
        if (!data)
          return;

        $.each(data, function(key, val) {
          
          if (key && val) {
           
            $elmCidade.append('<option value="' + key + '">' + val + '</option>');
            
          }
          
        });
      }
    });
    
    e.stopPropagation();
  });
  
  // Mostra Bairros se a cidade for igual da configuracao (combo ou campo texto)
  $elmCidade.change(function(e) {
    var $this = $(this);
    
    $.ajax({
      url     : $this.attr('ajax-url'),
      data    : $this.attr('campo-ref') + '=' + $this.val(),
      success : function(data) {
        data = JSON.parse(data);
        
        if (data.mostra_campo_texto) {
          
          $elmBairroTexto.parent().parent().show();
          $elmBairro.parent().parent().hide();
          
          js_carregaEnderecos(false);
          
        } else {
         
          $elmBairro.parent().parent().show();
          $elmBairroTexto.parent().parent().hide();
          
          js_carregaEnderecos(true);
          
        }
        
        $elmBairro.html('<option value=""></option>');
        
        if (!data)
          return;
        
        $.each(data, function(key, val) {
          
          if (key && val) {
            
            $elmBairro.append('<option value="' + key + '">' + val + '</option>');
            
          }
          
        });
      }
    });
    
    e.stopPropagation();
  });
  
  function js_carregaEnderecos (bVisivel) {
    
    var $this = $elmEndereco;
    
    if ($this.val() == '' || bVisivel == false) {
      
      $elmEnderecoTexto.parent().parent().show();
      $elmEndereco.html('').parent().parent().hide();
      
      return;
      
    } else {
      
      $elmEndereco.parent().parent().show();
      $elmEnderecoTexto.val('').parent().parent().hide();
      
    }
    
    $.ajax({
      url     : $this.attr('ajax-url'),
      data    : $this.attr('campo-ref') + '=' + $this.val(),
      success : function(data) {
        data = JSON.parse(data);
        
        if (!data) 
          return;
        
        //console.log(data);
        $.each(data, function(key, val) {
          
          if (key && val) {
            $elmEndereco.append('<option value="' + key + '">' + val + '</option>');
          }
          
        });
      }
    });
  };  

});

