$(document).ready(function() {
    $("select#contador").closest(".control-group").hide();
    $("input#cnpj").closest(".control-group").hide();

    $("input#cnpj").buscador({
        statusInput: "p.help-block",
        success: function(data) {
            $("p.help-block").html(data.razao_social);
            $("input#cgm").val(data.cgm);
            $("input#login").val(data.cnpj);
        }
    });

    $("select#tipo").change(function() {
        $("#login").val("");
        $("#cnpj").val("");
        
        if ($(this).val() == 2) { /* se for tipo contador busca a lista de contadores e mostra no select */
            $("input#cnpj").closest(".control-group").hide();
            $("select#contador").closest(".control-group").show();
            $("select#contador").change();
            $("input#login").attr('readonly',true);
        } else if ($(this).val() == 1) { //se for do tipo contribuinte, mostra input para busca por CNPJ
            $("select#contador").closest(".control-group").hide();
            $("input#cnpj").closest(".control-group").show();
            $("input#login").attr('readonly',true);           
        } else {
            $("select#contador").closest(".control-group").hide();
            $("input#cnpj").closest(".control-group").hide();
            $("input#login").attr('readonly',false);
        }
                
    });

    $("select#contador").change(function() {
        $("input#login").val($(this).val());
        $("input#cnpj").val($(this).val());
    });

    $("select#tipo").change();
});

