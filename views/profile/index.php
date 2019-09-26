<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
</head>
<body>
<h1>Your profile</h1>
<h3>Hello, <?php echo $showProfile['user_email']; ?></h3>
<p>Your balance - <?php echo $showProfile['balance']; ?></p>
<br/>
<hr>
<h2>Withdraw money from the account</h2>
<p>You can enter only numbers and only one dot<br/>
    Format - 32 or 2.5343 or 0.00323</p>
<form action="#" method="post">
    <input type="text" name="money_count" pattern="\d+(\.\d{1,30})?">
    <button type="submit" name="withdraw">Withdraw</button>
</form>

<?php if (isset($errors) && is_array($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<br/><br/>
<hr>
<a href="/logout/">
    <button>Exit</button>
</a>

</body>
</html>
