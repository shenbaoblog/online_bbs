<?php


const DB_HOST = 'mysql:host=localhost:8889,dbname=online_bbs,charset=utf8mb4';
const DB_USER = 'root';
const DB_PASSWORD = 'root';

try {
  $pdo = new PDO(DB_HOST, DB_USER, DB_PASSWORD);
  echo 'DB接続に成功しました';
} catch (PDOException $e) {
  echo 'DB接続に失敗しました', PHP_EOL;
  echo $e->getMessage(), PHP_EOL;
  exit;
}


$errors = array(); // エラーを格納する＄errors変数を初期化



// POSTなら保存処理を実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 名前が正しく入力されているかチェック
  $name = null;
  if (!isset($_POST['name']) || !strlen($_POST['name'])) {
    $errors['name'] = '名前を入力してください';
  } else if (mb_strlen($_POST['name']) > 40) {
    $errors['name'] = '名前は40文字以内で入力してください。';
  } else {
    $name = $_POST['name'];
  }

  // ひとことが正しく入力されているかチェック
  $comment = null;
  if (!isset($_POST['comment']) || !strlen($_POST['comment'])) {
    $errors['comment'] = 'ひとことを入力してください。';
  } else if (mb_strlen($_POST['comment']) > 200) {
    $errors['comment'] = 'ひとことは200文字以内で入力してください。';
  } else {
    $comment = $_POST['comment'];
  }
  // Webの仕組み上、name属性に指定したものが必ず送信されるとは限らないため、必ずisset()を用いてキーが存在するかを確認。

  // 作成日
  $created_at = date('Y-m-d H:i:s');

  // バリデーションの補足
  // ・入力されているか
  // ・文字列の長さが適切な範囲に収まっているか
  // ・数値が入力されているか
  // ・選択された値が項目として存在しているか
  // ・データベース上にすでに登録されている値か
  // ・URLなど特定の形式に則っているか

  // エラーがなければ保存
  if (count($errors) === 0) {
    // $sql = "INSERT INTO online_bbs.post (name, comment, created_at) VALUES ('田中', 'テストコメント','" . $date . "')";
    // $sth = $pdo->query($sql);

    // 保存するためのSQL文を作成
    $sql = 'INSERT INTO online_bbs.post (name, comment, created_at) VALUES (:name, :comment, :created_at)';
    $stmt = $pdo->prepare($sql);
    if (!$stmt) {
      exit($pdo->error);
    }
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
    $flag = $stmt->execute(
      // array(
      //   'name' => $name,
      //   'comment' => $comment,
      //   'created_at' => $created_at,
      // )
    );
    // 使用終了したので閉じる
    // $stmt = null;
    $stmt->closeCursor();
  }
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  exit();
}

// -------------------------------------------------------------------------------------
// 投稿された内容を取得するSQLを作成して、結果を取得
$stmt = $pdo->query('SELECT * FROM online_bbs.post ORDER BY created_at DESC');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_count = $stmt->rowCount();

// // 取得した結果を$postsに格納（事前に取得することで、DBとの接続を閉じても大丈夫にする）
// $posts = array();
// if ($rows !== false && $row_count) {
//   foreach ($rows as $key => $row) {
//     $posts[] = $row;
//   }
// }

// 使用終了したので閉じる
// $stmt = null;
$stmt->closeCursor();
$pdo = null;


include 'views/bbs_view.php';
