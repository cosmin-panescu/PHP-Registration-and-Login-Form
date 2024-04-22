<?php 
    session_start();
    
    include "configuration/dbconnect.php";

    $email = $pwd = "";
    $email_err = $pwd_err = "";
    $error = false;
    $no_user_message = "";

    if (isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $pwd = trim($_POST['pwd']);

        // validate inputs
        if ($email == "") {
            $email_err = "Please enter a email";
            $error = true;
        }        
        
        if ($pwd == "") {
            $pwd_err = "Please enter a password";
            $error = true;
        }

        if (!$error) {
            // proceed with login
            $sql = "SELECT * FROM users WHERE email = '{$email}'";
            $result = $conn->query($sql);

            // Verificăm dacă s-a găsit un utilizator cu emailul respectiv
            if ($result->num_rows > 0) {
                // Extragem rândul rezultat
                $row = $result->fetch_assoc();

                // Obținem parola stocată din baza de date
                $hashed_pwd = $row['password'];

                // Comparăm parola introdusă de utilizator cu parola stocată din baza de date
                if (password_verify($pwd, $hashed_pwd)) {
                    $_SESSION["name"] = $row["name"];
                    header("location: index.php");
                } else {
                    $pwd_err = "Parola nu este corecta.";
                }
            } else {
                $no_user_message = "Nu exista niciun utilizator cu acest email.";
            }    
        }
    }
    
    include "topMenu.php";
?>

<div class="container">
    <h1 class="my-5">Login</h1>
    <?php 
        if ($no_user_message) {
            echo "
            <div class='text-center m-auto w-50 my-5 p-3 border border-danger rounded'>$no_user_message</div>";
        }
    ?>
    <form action="" method="post" class="w-50 m-auto border border-primary rounded p-5">
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

        <div class="text-center mb-4">
            <button name="submit" type="submit" class="btn btn-primary mt-3">
                Login
            </button>
        </div>
        <p class="text-center">Don't have an accout? <a href="register.php" class="text-primary"> Register Here </a></p>
    </form>
</div>

</body>

</html>