$(function () {
  $("#codelist").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": [{extend: 'excel',title: ''}, "pdf"]
  }).buttons().container().appendTo('#codelist_wrapper .col-md-6:eq(0)');

  $('.fa-adjust').on('click', function () {
    if ($('body').hasClass('dark-mode')) {
      $('body').removeClass('dark-mode')
    } else {
      $('body').addClass('dark-mode')
    }
  })
});