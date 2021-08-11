$(document).ready(function(){
    $("form[name=vincula] input#submit").addClass("disabled");
    
    $("form[name=vincula] input#inscricao_municipal").buscador({
        statusInput : "form[name=vincula] input#nome_contribuinte",
        preSearch   : function() {
            $("form[name=vincula] input#submit").addClass("disabled");
        },
        success     : function(data) {
            if (data) {
                $("form[name=vincula] input#nome_contribuinte").val(data.nome);
                $("form[name=vincula] input#contribuinte").val(data.inscricao);
                $("form[name=vincula] input#submit").removeClass("disabled");
            }
        }
    });
    
    $("form[name=vincula]").submit(function() {
        if ($("form[name=vincula] input#submit").hasClass('disabled')) {
            return false;
        } else {
            return true;
        }
    }); 
    
    $("select#contribuinte").change(function() {
        var url = $(this).attr('ajax-url');
        
        $.ajax({
            url     : url,
            data    : 'usuario_contribuinte=' + $(this).val() + '&usuario=' + $("input[name=usuario]").val(),
            success : function(data) { 
                data = JSON.parse(data);
                
                $("input[type=checkbox]").attr('checked',false);
                
                $.each(data,function(i,acao) {
                    $("input#acao_" + acao).attr('checked',true);
                });
            }
        });
    });
});

