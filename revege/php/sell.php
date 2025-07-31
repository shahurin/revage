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
    <h1>出品画面</h1>
    <div class="center">
    <form action="sell2.php" method="post">
    <td><p>商品画像:<input type="file" name="image"></p></td>
    <tr> 
    <td><p>商品名: <input type="text" name="name" class="example2"></p></td>
    <tr>
    <tr>
    <td><p>詳細:<input type="password" name="detail" class="example2"></p></td>
    <tr>
    <tr>
    <td><p>価格:<input type="number" name="price" class="example2"></p></td>
    <tr>
    <input type="submit" value="出品する" class="button">
    </form>
</body>
</html>