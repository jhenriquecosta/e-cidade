$(document).ready(function(){
    $("#form-controle").off('submit');
    $("#form-controle").submit(function(e){
        var action = $(this).attr('action');
        e.preventDefault();
        $.ajax({
            type: 'post',
            data: $(this).serialize(),
            url: action,
            success: function(){
                document.location.reload();                
            },
            error: function(response){                
                $('#myModal').html(response.responseText);                
            }
        });
        
    });
    $("#envia-controle").click(function() {
        $("#form-controle").submit();
    });
    
});