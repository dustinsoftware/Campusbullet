<h1>Super Cool Admin Toolbox</h1>
<? if ($message): ?><p class="info"><?=$message?></p>
<? else:?><p>Praise the LORD. Blessed is the man who fears the LORD, who finds great delight in his commands. -Psalm 112:1</p>
<? endif; ?>

<p>There are <?=$user_count?> users registered.</p>
<h2>Pending activations:</h2>
<table>

<? foreach ($activation_rows as $row) { ?>
<form action="" method="post">
<input type="hidden" name="id" value="<?=$row['id']?>" />
<tr>
	<td><?=$row['email']?></td>
	<td><input type="submit" name="action" value="Resend email" /></td>
	<? if ($row['ipaddress']): ?>
	<td><input type="button" value="Ban IP Address" onclick="go('admin/banip?ip=<?=$row['ipaddress']?>')" />
	<? else: ?><td>No IP Address logged for this user.</td>
	<? endif; ?>
</tr>
</form>
<? } ?>
</table>


<h2>Latest 5 Accounts</h2>
<table>
<tr>
	<th>ID</th>
	<th>Username</th>
</tr>
<? foreach ($user_rows as $row) { ?>
<tr>
	<td><?=$row['id']?></td>
	<td><?=$row['username']?></td>
	<td><a href="<?=$url_base?>moderator/user/<?=$row['id']?>">Moderate</a></td>
</tr>
<? } ?>
</table>

