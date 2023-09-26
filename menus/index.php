<?php
if (!isset($_GET['role'])) die('Must have role parameter. Please try again.');
$role = strtolower($_GET['role']);

include('../preload.php');
include(HTML . 'beginHTML.php');

$sqlTable = new SQLTable();
?>
<div class="container text-center">
  <h2>KDGA Main Menu</h2>
  <div class="row">
<?php
$rows = $sqlTable->load('loadMenus', array());
foreach ($rows As $row) {
  $url_menu = KDGA_URL . $row['URL'] . '?role=' . $role;
?>
  <div class="row">
    <div class="col-12">
      <a class="links" href="<?php echo $url_menu; ?>">
        <div class="card <?php echo $row['TagName']; ?> text-white mb-1 full">
          <div class="card-body">
            <h5 class="card-title text-center"><?php echo $row['Title'] . ($row['Admin'] == 'Y' ? ' (for Admin only)' : ''); ?></h5>
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
