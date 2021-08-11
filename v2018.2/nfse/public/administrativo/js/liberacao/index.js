$(document).ready(function(){
    $("form[name=contribuinte] input#im").buscador({
        statusInput: "span#status",
        url: "/administrativo/liberacao/get-contribuinte/",
        success: function(data) {
            window.location.href = "/administrativo/liberacao/index/im/" + data.inscricao;
        }
    });
    
    $("#data_limite").datepicker({
        format: 'dd/mm/yyyy'        
    });
});