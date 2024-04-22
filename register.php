<?php 
    include "configuration/dbconnect.php";

    $name = $email = $pwd = $conf_pwd = "";
    $name_err = $email_err = $pwd_err = $conf_pwd_err = "";
    $error = false;
    $register_message = "";

    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $pwd = trim($_POST['pwd']);
        $conf_pwd = trim($_POST['conf_pwd']);

        // validate inputs
        if ($name == "") {
            $name_err = "Please enter a name";
            $error = true;
        }
        
        if ($email == "") {
            $email_err = "Please enter a email";
            $error = true;
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $name_err = "Invalid email format";
            $error = true;
        } else {
            $sql = "SELECT * FROM users WHERE email = '{$email}'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $error = true;
                $row = $result->fetch_assoc();
                $email_err = "Acest email este deja utilizat";
            }
        }
        
        if ($pwd == "") {
            $pwd_err = "Please enter a password";
            $error = true;
        }
        
        if ($conf_pwd == "") {
            $conf_pwd_err = "Please confirm the password";
            $error = true;
        }

        if ($pwd != "" && $conf_pwd != "") {
            if ($pwd != $conf_pwd) {
                $conf_pwd_err = "Passwords do not match";
                $error = true;
            }
        }

        if (!$error) {
            // proceed for registration
            $pwd = password_hash($pwd, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES ('{$name}', '{$email}', '{$pwd}');";

            if ($conn->query($sql)) {
                $register_message = "User has been registered!";
                $name = $email = $pwd = $conf_pwd = "";
            } else {
                $register_message = "Registration Error: " . $conn->error;
            }    
        }
    }
    
    include "topMenu.php";
?>

<div class="container">
    <h1 class="my-5">Registration</h1>
    <?php 
        if ($register_message) {
            echo "
            <div class='text-center m-auto w-50 my-5 p-3 border border-success rounded'>$register_message</div>";
}
?>
    <form action="" method="post" class="w-50 m-auto border border-primary rounded p-5">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input value="<?= $name ?>" type="text" class="form-control" name="name" id="name"
                placeholder="Enter you name">
            <div class="text-danger"><?= $name_err; ?></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input value="<?= $email ?>" type="text" class="form-control" name="email" id="email"
                placeholder="Enter you email">
            <div class="text-danger"><?= $email_err; ?></div>
        </div>
        <div class="mb-3">
            <label for="pwd" class="form-label">Password</label>
            <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Enter you password">
            <div class="text-danger"><?= $pwd_err; ?></div>
        </div>
        <div class="mb-3">
            <label for="conf_pwd" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="conf_pwd" id="conf_pwd"
                placeholder="Confirm the password">
            <div class="text-danger"><?= $conf_pwd_err; ?></div>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" value="checkedValue" aria-label="Show the password"
                id="show-pwd">
            Show Password
        </div>

        <div class="text-center mb-4">
            <button name="submit" type="submit" class="btn btn-primary">
                Register
            </button>
        </div>
        <p class="text-center">Already Registered? <a href="login.php" class="text-primary"> Login Here </a></p>
    </form>
</div>

<script src="javascript/script.js"></script>
</body>

</html>