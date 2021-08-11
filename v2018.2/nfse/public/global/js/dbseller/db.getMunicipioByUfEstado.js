$(function() {
  $('.select-estados').live('change', function() {
    var estado          = $(this);
    var id_select_munic = estado.attr('select-munic');
    var myurl           = estado.attr('ajax-url');
    var select_munic    = $('#' + id_select_munic);
    var haskey          = select_munic.attr('key');

    select_munic.html('');
    
    if (estado.val() != '0') {
      $.ajax({
        url      : myurl,
        data     : { 'uf' : estado.val() },
        async    : false,
        success  : function(data) {

          if (data) {

            var municipios = $.map(data, function(municipio) {
              return municipio;
            });

            municipios.sort();

            $.each(municipios, function(chaveMunicipio, municipio) {

              for(var chaveData in data) {

                if(data[chaveData] === municipio) {

                  var option  = '<option value="' + chaveData + '"';
                      option += ((select_munic.data('municipio-origem') == chaveData) ? ' selected="selected"' : '') + '>';
                      option += municipio + '</option>';
                  select_munic.append(option);
                }
              }
            });

            select_munic.change();
          }
        }
      });
    }
  });
  
  $('.select-paises').live('change', function() {
    var pais             = $(this);
    var id_select_estado = pais.attr('select-estado');
    var myurl            = pais.attr('ajax-url');
    var select_estado    = $('#' + id_select_estado);
    var haskey           = select_estado.attr('key');

    select_estado.html('');
    
    if (pais.val() != '0') {
      $.ajax({
        url    : myurl,
        data  : { 'cod' : pais.val() },
        async  : false,
        success  : function(data) {
          if (data) {

            $.each(data, function(key, val) {

              if (val != null) {

                var option = '<option value="' + (haskey ? key : val) + '"'
                  + ((select_estado.data('estado-origem') == key) ? ' selected="selected"' : '')
                  + '>' + val + '</option>';

                select_estado.append(option);
              }
            });

            select_estado.change();
          }
        }
      });
    }
  });
});