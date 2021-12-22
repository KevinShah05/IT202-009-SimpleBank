<?php require(__DIR__ . "/../../partials/nav.php"); ?>

<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>

<?php
$accounts = getDropDown();
?>

<?php
$result = [];
if (isset($id)) {
    $db = getDB();
    $stmt = $db->prepare("SELECT`Transactions`.`act_src_id` AS `id`, `Transactions`.`act_dest_id` as `did`, `amount`, `action_type` FROM `Transactions` WHERE `id` = :id");
    $r = $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $e = $stmt->errorInfo();
        flash($e[2]);
    }

    $stmt2 = $db->prepare("SELECT account_number FROM Accounts WHERE Accounts.id = :id");
    $r2 = $stmt2->execute([":id" => $id]);
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    if (!$result2) {
        $e = $stmt->errorInfo();
        flash($e[2]);
    }
}
?>


<h3>View Transaction</h3>
<ul class = "ViewTrans">
<body style= "background-color:bisque";></body>
<?php if (isset($result) && !empty($result)): ?>
    <div class="card">
        <div class="card-title">
        </div>
        <div class="card-body">
            <div>
                <p><b>Information</b></p> 
                
                <div>Amount: <?php safer_echo($result["amount"]); ?></div>
                <div>Action: <?php safer_echo($result["action_type"]); ?> </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>Error looking up id...</p>
<?php endif; ?>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>