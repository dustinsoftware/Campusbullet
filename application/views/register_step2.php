<form action="" method="post">
<h1 class="center">Register for The Campus Bullet</h1>
<p>Cool, your email address has been verified!&nbsp; You can now choose a username and password.</p>	
<? if ($errors) { ?><ul class="error"><? foreach ($errors as $error) echo "<li>$error</li>\r\n"; ?></ul><? } ?>
<table>
<tr><td>Email:</td><td><?=$email?></td></tr>
<tr><td>Username:</td><td><input type="textbox" name="user" value="<?=$user?>"/> (pick something cool if you want!)</td></tr>
<tr><td>Password:</td><td><input type="password" name="pw1"/></td></tr>
<tr><td>Confirm password:</td><td><input type="password" name="pw2" /></td></tr>
<tr><td></td><td><input type="checkbox" name="terms" value="accepted" />Yes, I agree to the terms of use as outlined in <a href="<?=$url_base?>help/terms">this short document</a>.</td></tr>
<tr><td></td><td><input type="submit" value="Create my account!" /></td></tr>
</table>

</form>
