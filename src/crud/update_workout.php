<?php
include '../../connection.php';

if (isset($_POST['workoutID'])) {
    $workoutID = $_POST['workoutID'];
    $selectQuery = "SELECT * FROM workout WHERE workout_id = '$workoutID'";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        ?>
        <!-- Edit workout Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editWorkoutModalLabel">Edit Workout Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing workout -->
                    <form action="../crud/workout_process.php" method="post">
                    <div class="form-group">
                                <input type="hidden" name="workoutID" value="<?php echo $record['workout_id']; ?>">
                                <label for="name">Workout Name</label>
                                <input type="text" class="form-control" name="name" id="name" required value="<?php echo $record['name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea class="form-control" name="desc" rows="3"><?php echo $record['description']; ?>"</textarea>
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
        <!-- End of Edit workout Modal -->
        <?php
    }
}
?>