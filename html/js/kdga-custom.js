/*
 * Program Name..: kdga-custom.js
 * Author........: Brian Timberlake
 * Date Created..: September 9, 2019
 * Description...: This is to execute the handles and behaviors attached to the couple of elements.
 */
$(document).ready(function() {
    $(".available").click(function() {
        if ($(this).hasClass("selected")) {
          $(this).removeClass("selected");
        } else {
          $(this).addClass("selected");
        }

        var boxSelected = "";
        $(".selected").each(function(index) {
          if (boxSelected !== "") boxSelected = boxSelected + ",";
          boxSelected = boxSelected + $(this).text();
        });
        $("#boxSelected").html(boxSelected);
    });

    $("#submitForm").click(function() {
      var str = $("#boxSelected").text();
      if ($.trim(str) === "") {
        alert("You have not select any squares. Please try again.");
      } else {
        document.location.href = "requestSquare.php?box=" + $.trim(str);
      }
    });
});
