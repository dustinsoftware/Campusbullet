<h1>User Management</h1>

<? if ($message): ?><p class="info"><?=$message?></p><? endif; ?>
<? if ($error): ?><p class="error"><?=$error?></p><? endif; ?>

<h2>User Row</h2>
<pre><?= $user_dump ?></pre>

<h2>Post History</h2>
<table>
<tr>
	<th>ID</th>
	<th>Post Name</th>
	<th>Post Date</th>
	<th>Status</th>
</tr>
<? foreach ($user_posts as $post) {
	echo "<tr>";
		echo "<td>$post[id]</td>";
		echo "<td><a href=\"" . $url_base . "home/view/$post[id]\">$post[name]</a></td>";
		echo "<td>$post[timestamp]</td>";
		echo "<td>";
		if ($post['disabled'] == 0) echo "Active";
		elseif ($post['disabled'] == 1) echo "Inactive";
		elseif ($post['disabled'] == 2) echo "Flagged";
		else echo "Unknown";
		echo "</td>";
	echo "</tr>\r\n";
} ?>
</table>

<h2>Message History</h2>
<? if ($message_history) : ?>
<table>
<tr>
	<th>To user:</th>
	<th>Count:</th>
</tr>
<? foreach ($message_history as $row) {
	echo "<tr>";
	echo "<td>$row[recipient]</td>";
	echo "<td>$row[count]</td>";
	echo "</tr>\r\n";
} ?>
</table>
<? else : ?>
<p>No message found for this user.</p>
<? endif; ?>

<h2>Log history:</h2>
<? if ($log_history) : 
	foreach ($log_history as $log) { ?>
		<p>Incident ID #<?=$log['id']?><br />
		<table style="margin-left: 20px">
		<tr>
			<td>Log date:</td>
			<td><?=$log['timestamp']?></td>
		</tr>
		<tr>
			<td>Log type:</td>
			<td><?=$log['log_type']?></td>
		</tr>
		<tr>
			<td>Message:</td>
			<td><?=$log['message']?></td>
		</tr>
		</table>
		</p>
	<? } 
 else : ?>
<p>No logs recorded for this user (yet).</p>
<? endif; ?>

<form action="" method="post">
<? if ($user_disabled == 0): ?>
<p>If the user is being disruptive, click the button below to start the account disable tool.&nbsp;
After a report has been filed, the user's account will be disabled and all posts made by that
user disabled (they can be recovered if the user needs to be enabled later).</p>
<? if ($banned_once): ?><p class="info">Warning: A ban will result if you disable their account!</p><? endif; ?>
<input type="submit" name="startincident" value="Log and disable this account" />

<? elseif ($user_disabled == 1 && $banned_once): ?>

<p>Their account has only been disabled once, and can be re-enabled.&nbsp; <strong>Re-enable with caution!</strong></p>
<input type="submit" name="enable" value="Re-enable the account" />
<? elseif ($user_disabled == 1): ?>
<p class="error">This user has been disabled more than once, and cannot have their account re-enabled.</p>
<? elseif ($user_disabled == 2): ?>
<p class="info">The user has disabled their own account, and must log in to enable it again.</p>
<? endif; ?>

</form>