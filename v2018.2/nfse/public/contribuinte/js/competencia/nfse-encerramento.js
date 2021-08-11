$(function(){

  $('#myModal').on('hidden.bs.modal', function (e) {
    window.location.reload();
  });
});