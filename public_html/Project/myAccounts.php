<?php require(__DIR__. "/../../partials/nav.php");?>

<?php
  $user = get_user_id();
  if(isset($user)){
  $results = [];
  $db = getDB();
  $stmt = $db->prepare("SELECT Accounts.user_id as UserID, Accounts.id as AccID, account_number, account_type, balance FROM Accounts WHERE Accounts.user_id = :q LIMIT 5");
  $r = $stmt->execute([":q" => $user]);
    if($r){
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else{
      flash("There was a problem listing your accounts"); 
    }
  }
?>
<ul class = "Account">
<body style= "background-color:bisque";></body>
<div class="results">
    <?php if (count($results) > 0): ?>
        <div class="list-group">
            <?php foreach ($results as $r): ?>
                <div class="list-group-item">
                <div class="row font-weight-bold"></div>
                
                    <div>
                        <div><strong>Account Number: </strong><?php safer_echo($r["account_number"]); ?></div>
                        
                    </div>
                    <div>
                        <div><strong>Account Type: </strong><?php safer_echo($r["account_type"]); ?></div>
                    </div>
                    <div>
                        <div><strong>Balance: </strong><?php safer_echo($r["balance"]); ?></strong></div>
                    </div>
                    <div>
                        <a type="button" href="my_transactions.php?id=<?php safer_echo($r["AccID"]); ?>">View Transaction History</a>
                        <p></p>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No results</p>
    <?php endif; ?>
</div>
</ul>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>