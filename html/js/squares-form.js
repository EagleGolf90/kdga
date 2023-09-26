function startAllOver() {
  $('#quarter').val("");
  for (var i = 1; i <= 10; i++) {
    $('#left_column' + i).val("");
    $('#top_column' + i).val("");
  }
}

$(document).ready(function() {
  $('#clearAll').click(function() {
    startAllOver();
  });

  $('#submitForm').click(function() {
    var quarter = $('#quarter :selected').text();
    let formData = $('.areaForm').serialize();

    $.ajax({
        method: "POST",
        url: 'add_draw_squares.php',
        data: formData,
        success: function(response) {
          startAllOver();
          alert(quarter + ' updated successful');
        },
        error: function(xhr, status, error) {
          alert('Failed');
        }
    });
  });
});
