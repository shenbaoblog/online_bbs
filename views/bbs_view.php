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
    <!-- エラー表示 -->
    <?php if (count($errors)) : ?>
      <ul class="error_list">
        <?php foreach ($errors as $key => $error) : ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>


    <div>
      <p>名前: <input type="text" name="name" /></p>
      <?php if (array_key_exists('name', $errors)) : ?>
        <p><?php echo htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8'); ?></p>
        <!-- ENT_QUOTES定数を指定する音で、シングルクォーテーションもエスケープ（デフォルトでは、シングルクォーテーションはエスケープされない。） -->
      <?php endif; ?>
    </div>
    <br />
    <div>
      <p>ひとこと: <input type="text" name="comment" size="60" /></p>
      <?php if (array_key_exists('comment', $errors)) : ?>
        <p><?php echo htmlspecialchars($errors['comment'], ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>
    </div>

    <!-- ボタン -->
    <input type="submit" name="submit" value="送信">
  </form>


  <h2>すべてのひとこと</h2>




  <?php if ($rows !== false && $row_count) : ?>
    <ul>
      <?php foreach ($rows as $key => $row) : ?>
        <li>
          id:<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?>
          name:<?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>
          comment:<?php echo htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8') ?>
          created_at:<?php echo htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8') ?><br>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>


</body>

</html>
