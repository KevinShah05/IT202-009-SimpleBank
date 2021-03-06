<?php
require(__DIR__ . "/../../partials/nav.php");
reset_session();
if(isset($_POST["submit"])){
    $email = se($_POST, "email", null, false);
    $password = trim(se($_POST, "password", null, false));   
    $confirm = trim(se($_POST, "confirm", null, false));
    $username = trim(se($_POST, "username", null, false));
    
    $isValid = true;
    if(!isset($email) || !isset($password) || !isset($confirm) || !isset($username)){
        //se("Must provide email, password, and confirm password");
        flash("Must provide email, password, and confirm password","warning");
        $isValid =false;

    }

    if ($password !== $confirm){
        //se("Passwords don't match");
        flash("Passwords don't match","warning");
        $isValid = false;
    } 
    if (strlen($password) < 6) {
        flash("Password must be 6 or more characters", "warning");
        $isValid = false; 
    }
   
    
    $email = sanitize_email($email);
    if(!is_valid_email($email)){
        flash("Invalid email", "warning");
        $isValid = false;
    }
    if($isValid){
        //do our registration
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, username, password) VALUES (:email, :username, :password)");
        $hash = password_hash($password, PASSWORD_BCRYPT);
        try {

            $stmt->execute([":email" => $email, ":password" => $hash, ":username"=>$username]);

            flash("You have succssfully registered, please login");
            die(header("Location: login.php"));

        } catch(PDOException $e) {
            
            $code = se($e->errorInfo, 0, "00000", false);
            if ($code === "23000") {
                flash("An account with this email already exists", "danger");
                
            } else {
                echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
            }    
        
        
        }    
    } 
}

?>
<div> 
    
    <form method="POST" onsubmit="return validate(this);">
    <ul class = "Register">
    <body style= "background-color:bisque";></body>
        <div>
            <lable for="email">Email: </lable>
            <input type="email" id="email" name="email" required />
        </div>
        <div>
            <lable for="username">Username: </lable>
            <input type="text" id="username" name="username" required />
        </div>
        <div>
            <lable for="pw">Password: </lable>
            <input type="password" id="pw" name="password" required />
        </div>
        <div>
            <lable for="cpw">Confirm Password: </lable>
            <input type="password" id="cpw" name="confirm" required />   
        </div>
        <div>
            <input type="submit" name="submit" value="Register" />
        </div>
    </form>
</ul>
<div>
<script>
    function validate(form){
        let email = form.email.value;
        let username = form.username.value;
        let password = form.password.value;
        let confirm = form.confirm.value;
        let isValid = true; 
        if (email){
            email = email.trim();
        }
        if (username){
            username = username.trim();
        }
        if(password){
            password = password.trim();
        }
        if(confirm ){
            confirm = confirm.trim();
        }
        if(!username || username.length === 0){
            isValid = false;
            alert("Must provide a username");
        }
        if(email.indexOf("@") === -1){
            isValid = false;
            alert("Invalid email");
        }
        if(password != confirm){
            isValid = false; 
            alert("password don't match");
        }
        if(password.length < 3){
            isValid = false;
            alert("password must be 3 or more characters");     
        }
        return isValid;
    }

</script>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>
