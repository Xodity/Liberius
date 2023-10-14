<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liberius : Framework based on JavaScript</title>
    <link rel="stylesheet" href="/css/global.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <img src="/src/Liberius.jpeg" alt="">
            <p><code>Start Edit At rune/views/index.rune.php</code></p>
            <?php if($flasher::has("msg_success")) : ?>
            <pre><?= $flasher::get("msg_success") ?></pre>
            <?php endif ?>
        </div>
    </div>
</body>
</html>
