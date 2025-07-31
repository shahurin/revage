
<?php
unset($_SESSION['アカウント']);
$pdo=new PDO('mysql:host=localhost;dbname=revege;charset=utf8',
            'revege_member','password');
$sql=$pdo->prepare('select * from customer where user_id=? and password=?');
$sql->execute([$_REQUEST['user_id'],$_REQUEST['password']]);
foreach ($sql as $row) {
    $_SESSION['アカウント']=[

        'id'=>$row['id'],
        'user_id'=>$row['user_id'],
        'name'=>$row['name'],
        'password'=>$row['password'],
    ];
}
if (isset($_SESSION['アカウント'])) {
    header('Location:revege.php');
    exit();
} else {
    echo 'ユーザーIDまたはパスワードが違います。';
}
?>