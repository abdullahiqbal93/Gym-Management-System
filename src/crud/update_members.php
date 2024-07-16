<?php
include '../../connection.php';

if (isset($_POST['memberID'])) {
    $memberID = $_POST['memberID'];
    $selectQuery = "SELECT * FROM member WHERE member_id = '$memberID'";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        ?>
        <!-- Edit Member Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMemberModalLabel">Edit Member Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing member -->
                    <form action="../crud/regprocess.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="memberID" value="<?php echo $record['member_id']; ?>">
                                <!-- Full Name -->
                                <div class="form-group">
                                    <label for="name">Full Name Of Participant</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" required
                                        value="<?php echo $record['full_name']; ?>">
                                </div>
                                <!-- Gender -->
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" name="gender" required>
                                        <option value="male" <?php echo ($record['gender'] == 'male') ? 'selected' : ''; ?>>Male
                                        </option>
                                        <option value="female" <?php echo ($record['gender'] == 'female') ? 'selected' : ''; ?>>
                                            Female</option>
                                    </select>
                                </div>
                                <!-- Date of Birth -->
                                <div class="form-group">
                                    <label for="dob">Date of birth</label>
                                    <input type="date" class="form-control" name="dob" required
                                        value="<?php echo $record['dob']; ?>">
                                </div>

                                <!-- Contact No -->
                                <div class="form-group">
                                    <label for="contact">Contact No</label>
                                    <input type="text" class="form-control" name="contact" required
                                        value="<?php echo $record['contact_no']; ?>">
                                </div>
                                <!-- Date of Join -->
                                <div class="form-group">
                                    <label for="doj">Date of Join</label>
                                    <input type="date" class="form-control" name="doj" required
                                        value="<?php echo $record['doj']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" name="email" required
                                        value="<?php echo $record['email']; ?>">
                                </div>
                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" required
                                        value="<?php echo $record['password']; ?>">
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
        <!-- End of Edit Member Modal -->
        <?php
    }
}
?>