<?php
include('../preload.php');
include(HTML . 'beginHTML.php');

$sqlTable = new SQLTable();
?>
<div class="container">
  <h2><?php echo BUS_UNIT; ?> Fundraising Main Menu</h2>
<?php
$rows = $sqlTable->load('loadMenus', array());
foreach ($rows As $row) {
?>
  <div class="row">
    <div class="col-12">
      <a class="links" href="<?php echo BASE_URL . $row['URL']; ?>">
        <div class="card <?php echo $row['TagName']; ?> text-white mb-3 full">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['Title'] . ($row['Admin'] == 'Y' ? ' (for Admin only)' : ''); ?></h5>
          </div>
        </div>
      </a>
    </div>
  </div>
<?php
}
?>
</div>

<?php include(HTML . 'endHTML.php'); ?>
