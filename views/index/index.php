<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main page</title>
</head>
<body>
<h1>Main page, Hello</h1>
<h4>Authorization</h4>

<?php if (isset($errors) && is_array($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="#" method="post">
    <input type="text" name="user_email" placeholder="Your email"><br/>
    <input type="password" name="user_password" placeholder="Your password"><br/>
    <button type="submit" name="user_submit">Sing in</button>
</form>
</body>
</html>

