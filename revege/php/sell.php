<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>revage</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="ここにサイト説明を入れます">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/vegas.min.css">
<link rel="stylesheet" href="css/style.css">
<meta name="google-site-verification" content="MRPhGeR6c_dv9NvU9oK2d3NhQAQp5UjSn2TiC-cO7s8" />
</head>
<body>
    <?php session_start();
        var_dump($_SESSION);  // ← ここでも user_id が見える//
    ?>
    <h1>出品画面</h1>
    <div class="center">
        <form action="sell2.php" method="post" enctype="multipart/form-data">
            <p>商品画像: <input type="file" name="image"></p>
            <p>商品名: <input type="text" name="name" class="example2"></p>
            <p>詳細:<br>
                <textarea name="detail" class="example2" rows="4" cols="40"></textarea>
            </p>
            <p>価格: <input type="text" name="price" class="example2"></p>
            <p><input type="submit" value="出品する" class="button"></p>
        </form>
    </div>
</body>
</html>