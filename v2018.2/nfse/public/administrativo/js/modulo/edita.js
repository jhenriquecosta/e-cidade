$(document).ready(function(){
    $("#form-modulo").off('submit');
    $("#form-modulo").submit(function(e){
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
    $("#envia-modulo").click(function() {
        $("#form-modulo").submit();
    });
    
});