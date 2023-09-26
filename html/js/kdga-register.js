$(document).ready(function(){
    $("#SignUp").click(function(event) {
        if ($(".terms").prop("checked") === false) {
          alert("You did not agree to the Terms and Agreement.");
          event.preventDefault();
          return false;
        } else {
          $("#SignUp").submit();
        }
    });

    $("#cancelBtn").click(function(event) {
      history.go(-1);
    });
});
