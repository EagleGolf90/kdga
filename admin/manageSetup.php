<?php
include('../preload.php');
include(INCLUDES . 'initialize_golf.php');

include(HTML . 'beginHTML.php');
include(MENUS . 'navbar.php');
?>

<form class="regForm" action="modify.php" method="post">
  <input type="text" name="page" value="modifysetup" hidden>
  <input type="text" name="yearPlayed" value="2023" hidden>

  <div class="container-form">
    <?php
    $display_message = '<h3>Manage Setup</h3>';
    include(INCLUDES . 'display_message.php');
    ?>

    <div row="row">
      <div class="col-md-12">
        <div class="form-floating mb-3">
          <input type="text" name="final_cut" class="form-control" id="floatingInput" value="<?php echo $golf->getFinalCut(); ?>">
          <label for="final_cut">Final Cut</label>
        </div>
      </div>
    </div>

    <?php include(INCLUDES . 'submit_button.php'); ?>
  </div>
</form>

<?php include(HTML . 'endHTML.php'); ?>
