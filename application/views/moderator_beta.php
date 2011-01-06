<h1>Beta Account Activation</h1>
<? if ($message) { ?><p class="info"><?=$message?></p><? } ?>
<p>Pending beta registrations are shown below:</p>

<? if ($users) { ?>
<form action="" method="post">
<table>
<? foreach ($users as $user)
	echo "<tr><td><input type=\"checkbox\" name=\"user[]\" value=\"$user[id]\" /></td><td>$user[email]</td></tr>\r\n";
?>
</table>
	
<input type="submit" value="Activate Accounts" /><br />
</form>

<? } else { ?>
<p>No beta accounts were found.</p>
<? } ?>