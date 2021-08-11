$(document).ready(function(){
	$("#form-acao").off('submit');
    $("#form-acao").submit(function(e){
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
    $("#envia-acao").click(function() {
        $("#form-acao").submit();
    });
    
});