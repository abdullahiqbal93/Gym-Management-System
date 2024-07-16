<?php
include '../../connection.php';

if (isset($_POST['trainerID'])) {
    $trainerID = $_POST['trainerID'];
    $selectQuery = "SELECT * FROM trainer WHERE trainer_id = '$trainerID'";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        ?>
        <!-- Edit Equipment Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTrainerModalLabel">Edit Trainer Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing trainer -->
                    <form action="../crud/trainer_process.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="trainerID" value="<?php echo $record['trainer_id']; ?>">
                                    <label for="name">Trainer Name</label>
                                    <input type="text" class="form-control" name="name" required
                                        value="<?php echo $record['full_name']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="specialization">Specialization</label>
                                    <input type="text" class="form-control" name="specialization" required
                                        value="<?php echo $record['specialization']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="contact">Contact No</label>
                                    <input type="text" class="form-control" name="contact" id="" required
                                        value="<?php echo $record['contact_no']; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="" required
                                        value="<?php echo $record['email']; ?>">
                                </div>

                                <div class="form-group">

                                    <label for="salary">Salary</label>
                                    <input type="text" name="salary" id="" class="form-control" required
                                        value="<?php echo $record['salary']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="photo" style="display:block;">Upload Photo</label>
                                    <input type="file" name="photo" id="">
                                    <?php
                                    // Display the current photo if it exists
                                    if (isset($record['photo'])) {
                                        echo "<img src='{$record['photo']}' alt='Current Photo' style='max-width: 100px;'>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary edit" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary edit" name="edit_register">Save
                                Changes</button>
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