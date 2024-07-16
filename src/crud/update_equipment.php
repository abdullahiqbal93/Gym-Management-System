<?php
include '../../connection.php';

if (isset($_POST['equipmentID'])) {
    $equipmentID = $_POST['equipmentID'];
    $selectQuery = "SELECT * FROM equipment WHERE equipment_id = '$equipmentID'";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        ?>
        <!-- Edit Equipment Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEquipmentModalLabel">Edit Equipment Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing equipment -->
                    <form action="../crud/equipment_process.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="equipmentID" value="<?php echo $record['equipment_id']; ?>">

                                <div class="form-group">
                                    <label for="name">Equipment Name</label>
                                    <input type="text" class="form-control" name="name" required
                                        value="<?php echo $record['name']; ?>">
                                </div>

                                <div class="form-group">
                                    <label style="display:block;" for="qty">Quantity</label>
                                    <input type="number" class="form-control" style="border:1px solid #ced4da;" name="qty" id=""
                                        required value="<?php echo $record['quantity']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" name="desc"
                                        rows="3"><?php echo $record['description']; ?></textarea>
                                </div>

                            </div>

                            <div class="col-md-6">


                                <div class="form-group">
                                    <label for="price" style="display:block;">Unit Price</label>
                                    <input type="text" style="border:1px solid #ced4da;" name="price" id="priceInput"
                                        class="form-control" required value="<?php echo $record['unit_price']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="photo" style="display:block;">Upload Photo</label>
                                    <input type="file" name="photo" id="">
                                </div>
                                <?php
                                    // Display the current photo if it exists
                                    if (isset($record['photo'])) {       
                                        echo "<div class='form-group'><img src='{$record['photo']}' alt='Current Photo' style='max-width: 100px;'></div>";
                                    }
                                    ?>
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
        <!-- End of Edit Equipment Modal -->
        <?php
    }
}
?>