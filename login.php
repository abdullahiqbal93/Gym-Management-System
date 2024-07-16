<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="./css/login_signup.css">
    <title>AMA | Login</title>
</head>

<body>
    <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <img src="./image/login/login.jpg" alt="">
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <form action="./src/crud/login_process.php" method="post" id="login_form">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="text" placeholder="Email" name="email" required>
                            </div>
                            <div class="error-message"></div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <?php
                            session_start();
                            $error = isset ($_SESSION['error']) ? $_SESSION['error'] : "";
                            unset($_SESSION['error']);
                            ?>
                            <div class="error-message">
                                <?php echo $error; ?>
                            </div>
                            <div class="text"><a href="./src/password_reset.php">Forgot password?</a></div>
                            <div class="button input-box">
                                <input type="submit" name="login" value="Submit">
                            </div>
                            <div class="text sign-up-text flip-button">Don't have an account? <label for="flip"
                                    class="flip-button">Sign up</label></div>
                        </div>
                    </form>
                </div>
                <div class="signup-form">
                    <div class="title">Signup</div>
                    <form action="./src/crud/regprocess.php" method="post" enctype="multipart/form-data">
                        <div class="input-boxes">
                            <div class="input-box">
                                <input type="text" placeholder=" Full name" name="name" required>
                            </div>
                            <div class="error-message"></div>
                            <div class="input-box">
                                <input type="text" name="dob" placeholder="Date of birth" onfocus="(this.type='date')"
                                    onblur="(this.type='text')" />
                            </div>
                            <div class="error-message"></div>
                            <div class="input-box">
                                <input type="text" name="gender" placeholder="Gender" required>
                            </div>
                            <div class="error-message"></div>
                            <div class="input-box">
                                <input type="text" name="contact" placeholder="Contact No" required maxlength="10">
                            </div>
                            <div class="error-message"></div>
                            <div class="input-box">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="error-message"></div>
                            <div class="input-box">
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="error-message"></div>
                            <div class="button input-box">
                                <input type="submit" value="Submit" name="submit">
                            </div>
                            <div class="text sign-up-text">
                                Already have an account?
                                <label for="flip" class="flip-button">Login now</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('flip').addEventListener('change', function () {
            if (this.checked) {
                document.querySelector('.login-form').style.transform = 'rotateY(180deg)';
                document.querySelector('.signup-form').style.transform = 'rotateY(0)';
            } else {
                document.querySelector('.login-form').style.transform = 'rotateY(0)';
                document.querySelector('.signup-form').style.transform = 'rotateY(-180deg)';
            }
        });
    </script>

</body>

</html>