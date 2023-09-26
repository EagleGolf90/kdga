    <table class='table table-bordered table-hover'>
    <tr><td id='headerTitle'><b>Total People Paid:</b></td><td><b><?php echo $totalPeoplePaids; ?></b></td></tr>
    <tr><td id='headerTitle'><b>Total People UnPaid:</b></td><td><b><?php echo $totalPeopleUnPaids; ?></b></td></tr>
    <tr><td id='headerTitle'><b>Total Squares:</b></td><td><b><?php echo $payment->getTotalSquares(); ?></b></td></tr>
    <tr><td id='headerTitle'><b>Total People:</b></td><td><b><?php echo $totalPeople; ?></b></td></tr>
    <tr><td id='headerTitle'><b>Total Paid:</b></td><td><b>$<?php echo $totalPaids; ?></b></td></tr>
    <tr><td id='headerTitle'><b>Total UnPaid:</b></td><td><b>$<?php echo $totalUnPaids; ?></b></td></tr>
    <tr><td id='headerTitle'><b>Grand Total:</b></td><td><b>$<?php echo $totalDollars; ?></b></td></tr>
    </table>
