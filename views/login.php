<h1>You need to login first!</h1>

<? if ($error) { ?>
<p style="color:red"><?=$error ?></p>
<? } else { ?>
<p>If you've been given beta access, please login below.</p>
<? } ?>

<form method="POST">
<table>
<tr>
	<th>Yo name</th>
	<td><input type="textbox" name="user" /></td>
</tr>
<tr>
	<th>Yo password</th>
	<td><input type="password" name="asdf" /></td>
</tr>
<tr>
	<th></th>
	<td><input type="submit" name="submit" value="Log in!"/></td>
</tr>
</table>
</form>