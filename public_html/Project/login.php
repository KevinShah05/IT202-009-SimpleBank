<?php
require(__DIR__. "/../../partials/nav.php");
 //TODO 2: add PHP Code
 if(isset($_POST["email"]) && isset($_POST["password"])){
     //get the email key from $_POST, default to "" if not set, and return the value
     $email = se($_POST, "email","", false);

     //same as above but for password and confirm
     $password = trim(se($_POST, "password", "", false));
     $isValid = true;
     if(!isset($email) || !isset($password)){
         se("Must provide email, password");
     }
     if(strlen($password) < 3){
        se("passwrod must be 3 or more characters");
        $isValid = false;
     }

     $email= sanitize_email($email);
     if (!is_valid_email($email)){
        se("Invalid email");
        $isValid = false;
     }
     if ($isValid){
        //do our registration
        $db = getDB();
        //$stmt = $db->prepare("INSERT INTO Users(email, password) VALUES (:email, :password)");
        $stmt = $db->prepare("SELECT id, email, password from Users where email = :email");
        try{
            $stmt->execute(["email"=>$email,]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user){
                $upass = $user["password"];
                if(password_verify($password , $upass)){
                    se("yay we loged in");
                    unset($user["password"]);
                    $_SESSION["user"] = $user;
                    echo "<pre>" . var_export($_SESSION, true) . "</pre>";
                    die(header("Location: home.php"));
                }
                else{
                    se("password dont exist");
                }
            } else{
                se("User does not exist");
            }
        } catch (Exception $e){
            $code = se($e->errorInfo, 0, "00000", false);
            if($code === "23000"){
                se("AN account with this email already exist");
            }
            else{
                echo "<prep>" . var_export($e->errorInfo, true) . "</prep>";
            }
        }
     }
 }
?>
<div>
    <h1>Login</h1>
    <form onsubmit="return validate(this)" method="POST">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" required />
        </div>
        <div>
            <label for="pw">Password</label>
            <input type="password" id="pw" name="password" required minlength="8" />
        </div>
        <div?>
            <input type="submit" value="login" />
        </div>
    </form>
</div>
<script>
    function validate(form) {
        //TODO 1: implement JavaScript validation
        let email = form.email.value
        let password = form.password.value

        //ensure it returns false for an error and true for success
        if(email){
            email = email.trim();
        }
        if(password){
            password = password.trim();
        }
        if(email.indexOf("@")=== -1){
            isValid = false;
            alert ("Invalid email");
        }
        if(password.length < 3){
            invalid = false;
            alert ("passwrod must be 3 or more characters");
        }
        return isValid;
    }
</script>