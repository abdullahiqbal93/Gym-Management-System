<?php
include '../../connection.php';

if (isset($_POST['packageID'])) {
    $packageID = $_POST['packageID'];
    $selectQuery = "SELECT * FROM package WHERE package_id = '$packageID'";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        ?>
        <!-- Edit Package Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPackageModalLabel">Edit Package Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing package -->
                    <form action="../crud/package_process.php" method="post">
                    <div class="form-group">
                                <input type="hidden" name="packageID" value="<?php echo $record['package_id']; ?>">
                                <label for="name">Package Name</label>
                                <input type="text" class="form-control" name="name" id="name" required value="<?php echo $record['name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea class="form-control" name="desc" rows="3"><?php echo $record['description']; ?>"</textarea>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" id="price" required value="<?php echo $record['price']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration(days)</label>
                                <input type="number" class="form-control" name="duration" id="duration" required value="<?php echo $record['duration']; ?>">
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