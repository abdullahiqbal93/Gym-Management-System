<?php
include '../../connection.php';

if (isset($_POST['paymentID'])) {
    $paymentID = $_POST['paymentID'];
    $selectQuery = "SELECT * FROM payment WHERE payment_id = '$paymentID'";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        ?>
        <!-- Edit Payment Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing payment -->
                    <form action="../crud/payment_process.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="paymentID" value="<?php echo $record['payment_id']; ?>">
                                    <label for="member_id">Member ID</label>
                                    <input type="text" class="form-control" name="member_id" required
                                        value="<?php echo $record['member_id']; ?>">
                                </div>

                                <div class="form-group package-type">
                                    <label for="package">Package Type</label>
                                    <select class="form-control" name="package">
                                        <option value="">Please Select</option>
                                        <?php
                                        $sql = "SELECT package_id, name FROM package";
                                        $result = $con->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = ($record['package_id'] == $row['package_id']) ? 'selected' : '';
                                                echo "<option value='" . $row['package_id'] . "' $selected>" . $row['name'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No Packages found</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" name="amount" required
                                        value="<?php echo $record['amount']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="payment_date">Payment Date</label>
                                    <input type="date" class="form-control" name="payment_date" required
                                        value="<?php echo $record['payment_date']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="approved" <?php echo ($record['payment_status'] == 'approved') ? 'selected' : ''; ?>>
                                            Approved</option>
                                        <option value="pending" <?php echo ($record['payment_status'] == 'pending') ? 'selected' : ''; ?>>Pending
                                        </option>
                                        <option value="declined" <?php echo ($record['payment_status'] == 'declined') ? 'selected' : ''; ?>>
                                            Declined</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="edit_register">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of Edit Payment Modal -->
        <?php
    }
}
?>