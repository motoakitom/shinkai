<?php
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $activity = $_POST['activity'] ?? '';
    $date = $_POST['date'] ?? '';
    $message = $_POST['message'] ?? '';

    // バリデーション
    $errors = [];
    if (empty($name)) $errors[] = 'お名前を入力してください';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = '正しいメールアドレスを入力してください';
    if (empty($activity)) $errors[] = 'アクティビティを選択してください';
    if (empty($date)) $errors[] = '希望日を選択してください';

    if (empty($errors)) {
        // メール送信処理
        $to = 'your-email@example.com'; // 実際のメールアドレスに変更してください
        $subject = '【株式会社SHINKAI】予約申し込み';
        $body = "
        以下の内容で予約申し込みがありました。

        お名前：{$name}
        メールアドレス：{$email}
        アクティビティ：{$activity}
        希望日：{$date}
        メッセージ：{$message}
        ";

        $headers = "From: {$email}\r\n";
        $headers .= "Reply-To: {$email}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $success = true;
        } else {
            $errors[] = 'メール送信に失敗しました。もう一度お試しください。';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約完了 | 株式会社SHINKAI</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="reservation-result">
        <?php if (isset($success) && $success): ?>
            <h2>予約申し込み完了</h2>
            <p>予約申し込みを受け付けました。</p>
            <p>確認のメールを送信させていただきますので、しばらくお待ちください。</p>
            <a href="index.html" class="back-button">トップページに戻る</a>
        <?php else: ?>
            <h2>予約申し込みエラー</h2>
            <?php if (!empty($errors)): ?>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <a href="index.html#reservation" class="back-button">予約フォームに戻る</a>
        <?php endif; ?>
    </div>
</body>
</html> 