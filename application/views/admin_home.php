<h1>Super Cool Admin Toolbox</h1>
<? if ($message): ?><p class="info"><?=$message?></p>
<? else:?><p>"Power intoxicates men. When a man is intoxicated by alcohol, he can recover, but when intoxicated by power, he seldom recovers."</p>
<? endif; ?>

<h2>Pending activations:</h2>
<table>
<tr>
	<th>Email</th>
	<th>Resend link</th>
	<th>IP Address</th>
</tr>
<? foreach ($activation_rows as $row): ?>
<tr>
	<td><?=$row['email']?></td>
	<td><a href="<?=$url_base?>admin/resend/<?=$row['id']?>">Resend email</a></td>
	<td><?=$row['ipaddress']?></td>
</tr>
<? endfor; ?>
</table>

<h2>Latest 5 Accounts</h2>
<table>
<tr>
	<th>ID</th>
	<th>Username</th>
</tr>
<? foreach ($user_rows as $row): ?>
<tr>
	<td><?=$row['id']?></td>
	<td><?=$row['username']?></td>
	<td><a href="<?=$url_base?>moderate/user/<?=$row['id']?>">Moderate</a></td>
</tr>
<? endfor; ?>
</table>

