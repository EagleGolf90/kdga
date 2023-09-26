  <div row="row">
    <div class="col-md-12">
      <div class="form-floating mb-3">
        <select name="roundPlayed" class="form-select">
        <?php
        foreach ($rounds as $row) {
  ?>
          <option value="<?php echo $row['RoundPlayed']; ?>"><?php echo $row['DatePlayed']; ?></option>
  <?php
        }
  ?>
        </select>
        <label for="roundPlayed">Date Played</label>
      </div>
    </div>
  </div>
