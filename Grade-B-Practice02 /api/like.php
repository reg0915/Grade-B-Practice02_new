<?php include_once "db.php";

$id = $_POST['id'];
// $_SESSION全域變數，將$_SESSION['user']的值設為$user
$user = $_SESSION['user'];

$chk = $Log->count(['news' => $id, 'user' => $user]);

if ($chk > 0) {
    $Log->del(['news' => $id, 'user' => $user]);
} else {
    $Log->save(['news' => $id, 'user' => $user]);

}
