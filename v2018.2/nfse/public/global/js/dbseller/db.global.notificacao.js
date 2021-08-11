$(function() {

  // Remove as notificações quando clicado no botão fechar da mensagem
  $('div.alert button.close').click(function() {

    var dataParams = $(this).data();

    $.ajax({
      type: 'POST',
      url: '/global/notificacao/remover',
      data: dataParams,
      success : function(data) {

        if (data.status) {

          $('li#notificacoes ul li#' + dataParams.codigo).remove();

          if (data.count < 1) {
            $('li#notificacoes').remove();
          } else {
            $('span.badge .badge-important').text(data.count);
          }
        }
      }
    });
  });
});
