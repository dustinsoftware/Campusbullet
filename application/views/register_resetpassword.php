<h1 class="center">Reset your password</h1>
<p>All right, we believe you are who you say you are.&nbsp; Enter a new password below and we'll forget this ever happened.</p>
<? if ($errors) { ?><ul class="error"><? foreach ($errors as $error) echo "<li>$error</li>\r\n"; ?></ul><? } ?>
<form method="post" action="">
<table>
<tr><td>New password:</td><td><input type="password" name="pw1" /></td></tr>
<tr><td>Confirm password:</td><td><input type="password" name="pw2" /></td></tr>
<tr><td>When you're ready..</td><td><input type="submit" name="submit" value="Change password" /></td></tr>
</table>
</form>