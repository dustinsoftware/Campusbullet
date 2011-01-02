<h1 class="center">Forgot your password?</h1>
<p>Hey, no sweat.&nbsp; Everyone forgets their password from time to time.&nbsp; Just enter the email address you registered with below and we'll
send an email with a link to reset your password.</p>
<? if ($errors) { ?><ul class="error"><? foreach ($errors as $error) echo "<li>$error</li>\r\n"; ?></ul><? } ?>
<form method="post" action="">
<table>
<tr><td>Email address:</td><td><input type="textbox" name="email" /></td><td><input type="submit" name="submit" value="Send email" /></td></tr>
</table>
</form>