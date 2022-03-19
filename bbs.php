<?php
$user = 'root';
$pass = 'root';

try {
  $database_handler = new PDO('mysql:host=localhost:8889,dbname=online_bbs,charset=utf8mb4', $user, $pass);
} catch (PDOException $e) {
  echo 'DB接続に失敗しました', PHP_EOL;
  echo $e->getMessage(), PHP_EOL;
  exit;
}
echo 'DB接続に成功しました';

$errors = array(); // エラーを格納する絵＄errors変数を初期化

// POSTなら保存処理を実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 名前が正しく入力されているかチェック
  $name = null;
  if (!isset($_POST['name']) || !strlen($_POST['name'])) {
    $errors['name'] = '名前を入力してください';
  } else if (mb_strlen($_POST['name']) > 40) {
    $error['name'] = '名前は40文字以内で入力してください。';
  } else {
    $name = $_POST['name'];
  }

  // ひとことが正しく入力されているかチェック
  $comment = null;
  if (!isset($_POST['comment']) || !strlen($_POST['comment'])) {
    $error['comment'] = 'ひとことを入力してください。';
  } else if (mb_strlen($_POST['comment']) > 200) {
    $error['comment'] = 'ひとことは200文字以内で入力してください。';
  } else {
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ひとこと掲示板</title>
</head>

<body>
  <h1>ひとこと掲示板</h1>
  <form action="bbs.php" method=post>
    <p>名前: <input type="text" name="name" /></p>
    <p>ひとこと: <input type="text" name="comment" size="60" /></p>
    <input type="submit" name="submit" value="送信">
  </form>
</body>

</html>
