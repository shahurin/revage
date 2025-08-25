
<?php
session_start();
unset($_SESSION['customer']);
$pdo=new PDO('mysql:host=localhost;dbname=revege;charset=utf8',
            'revege_staff','password');
$sql=$pdo->prepare('select * from customer where user_id=? and password=?');
$sql->execute([$_REQUEST['user_id'],$_REQUEST['password']]);
foreach ($sql as $row) {
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['customer']=[
        'id'=>$row['id'],
        'user_id'=>$row['user_id'],
        'name'=>$row['name'],
        'password'=>$row['password'],
        'address' =>$row['address']
    ];
}
if (isset($_SESSION['customer'])) {
    header('Location:revege.php');
    exit();
} else {
    echo 'ユーザーIDまたはパスワードが違います。';
}
?>

