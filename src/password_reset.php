<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/login_signup.css">
    <title>AMA | Login</title>
</head>
<body>
<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
        <div class="front">
            <img src="../image/login/login.jpg" alt="">
        </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Forget Password</div>
                <form action="./crud/pwd_reset_process.php" method="post" id="login_form">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" placeholder="Email" name="email" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="text" name="id" placeholder="Member ID" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="text" name="name" placeholder="Full Name" required>
                        </div>
                        <div class="input-box">
                            <input type="text" name="dob" required placeholder="Date of birth" onfocus="(this.type='date')" onblur="(this.type='text')"/>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="New Password" required>
                        </div>
                        <div class="text"><a href="../login.php">LOGIN?</a></div>
                        <div class="button input-box">
                            <input type="submit" name="change" value="Submit">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

</body>
</html>
