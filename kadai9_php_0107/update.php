<?php

session_start();
require_once('funcs.php');
loginCheck();

//1. POSTデータ取得
$name   = $_POST['name'];
$bookurl  = $_POST['bookurl'];
$bookcomment    = $_POST['bookcomment'];
$id = $_POST['id'];

//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'UPDATE
        gs_bm_table  SET name = :name , bookurl = :bookurl, bookcomment = :bookcomment,  date = sysdate()
        WHERE id = :id;');
       

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);
$stmt->bindValue(':bookcomment', $bookcomment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); 
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
//*** function化する！******\
$error = $stmt->errorInfo();
exit('SQLError:' . print_r($error, true));
} else {
//*** function化する！*****************
header('Location: select.php');
exit();
}