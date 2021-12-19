<?php require(__DIR__ . "/../../partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: " . getURL("login.php")));
}
?>
<?php
$query = "";
$results = [];

if (isset($_POST["query"])) {
    $query = $_POST["query"];
    
}

if(isset($_POST["search"]) && !empty($query)){
  $db = getDB();
  $stmt = $db->prepare("SELECT id, account_number, account_type, balance, user_id FROM Accounts WHERE account_number like :q LIMIT 10");
  $r = $stmt->execute([":q" => "%$query%"]);



  if($r){
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  else{
    flash("There was a problem fetching the results"); 
  }

}

?>
<form method="POST">
    <input name="query" placeholder="Search" value="<?php safer_echo($query); ?>"/>
    <input type="submit" value="Search" name="search"/>
</form>

<ul class = "ViewAcc">
<body style= "background-color:bisque";></body>
<div class="results">
    <?php if (count($results) > 0): ?>
        <div class="list-group">
            <?php foreach ($results as $r): ?>
                <div class="list-group-item">
                

                    <div>
                        <div>Account Number: <?php safer_echo($r["account_number"]); ?></div> 
                    </div>
                    <div>
                        <div>Account Type: <?php safer_echo($r["account_type"]); ?></div>
                    </div>
                    <div>
                        <div>Balance: <?php safer_echo($r["balance"]); ?></div>
                    </div>
                    <div>
                        <div>Owner Id: <?php safer_echo($r["id"]); ?></div>
                    </div>
                    <div>
                        <a type="button" href="edit_account.php?id=<?php safer_echo($r['id']); ?>">Edit</a>
                        <a type="button" href="view_account.php?id=<?php safer_echo($r['id']); ?>">View</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No results (from local)</p>
    <?php endif; ?>
</div>
</ul>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>
