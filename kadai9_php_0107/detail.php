<?php

session_start();
require_once('funcs.php');
loginCheck();

$id = $_GET['id']; //?id~**を受け取る
require_once('funcs.php');
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_bm_table WHERE id=:id;');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    $result = $stmt->fetch();
}



?>





<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="POST" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>キャンプ欲しいものリスト</legend>
                <label>商品名：<input type="text" name="name" value="<?= h($result['name'])?>"></label><br>
                <label>商品URL：<input type="text" name="bookurl" value="<?= h($result['bookurl'])?>"></label><br>
                <label>商品コメント：<br><textArea name="bookcomment" rows="4" cols="40"><?= h($result['bookcomment'])?></textArea></label><br>


                <input type="hidden" name="id" value="<?= h($result['id'])?>">
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
</body>

</html>
