function startAllOver() {
  $('#showNames').val("");
  $('#leftTeam').val("");
  $('#topTeam').val("");
}

$(document).ready(function() {
  $('#clearAll').click(function() {
    startAllOver();
  });

  $('#submitForm').click(function() {
    let formData = $('.areaForm').serialize();

    $.ajax({
        method: "POST",
        url: 'update_teams.php',
        data: formData,
        success: function(response) {
          startAllOver();
          alert('Updated successful');
        },
        error: function(xhr, status, error) {
          alert('Failed');
        }
    });
  });
});
