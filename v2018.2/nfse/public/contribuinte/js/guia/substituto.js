$(document).ready(function() {
    $("input[type=checkbox]").click(function() {
        if (!!$(this).attr("checked")) {
            $(this).parents("tr").addClass("info");
        } else {
            $(this).parents("tr").removeClass("info");
        }
    });

    $("#guia-tomador").click(function() {
        var notas = [];
        $(":checked").each(function(i, v) {
            notas.push($(v).data('nota'));
        });

        $.ajax({
            url: '/contribuinte/guia/tomador',
            data: $(":checked").serialize(),
            type: 'POST',
            success: function(response) {
                $("#myModal").html(response);
            }
        });
        
        $("#myModal").modal('toggle');
    });
    
    $("#ok-btn").click(function() {
        window.location.reload();
    });

});


