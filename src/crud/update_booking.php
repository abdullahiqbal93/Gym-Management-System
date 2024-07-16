<?php
include '../../connection.php';

if (isset($_POST['bookingID'])) {
    $bookingID = $_POST['bookingID'];
    $selectQuery = "SELECT * FROM booking WHERE booking_id = '$bookingID'";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        ?>
        <!-- Edit Booking Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookingModalLabel">Edit Booking Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing booking -->
                    <form action="../crud/booking_process.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="bookingID" value="<?php echo $record['booking_id']; ?>">
                                    <label for="member_id">Member ID</label>
                                    <input type="text" class="form-control" name="member_id" required
                                        value="<?php echo $record['member_id']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="package">Package Type</label>
                                    <select class="form-control" name="package" required>
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
                                <div class="form-group">
                                    <label for="booking_date">Booking Date</label>
                                    <input type="date" class="form-control" name="booking_date" id="booking_date" required
                                        value="<?php echo $record['booking_date']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="approval_status">Approval Status</label>
                                    <select class="form-control" name="approval_status" id="approval_status">
                                        <option value="">Please Select</option>
                                        <option value="approved" <?php echo ($record['approval_status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                        <option value="pending" <?php echo ($record['approval_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="rejected" <?php echo ($record['approval_status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="approval_date">Approval Date</label>
                                    <input type="date" class="form-control" name="approval_date" id="approval_date">
                                </div>
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="date" class="form-control" name="expiry_date" id="expiry_date">
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
        <!-- End of Edit booking Modal -->
        <?php
    }
}
?>