<h1>Your Inbox of Awesome</h1>

<p>You're lucky enough to have a local inbox.</p>

<? if ($messages) { ?>
<table>
<tr>
	<th>Status</th>
	<th>From</th>
	<th>Snippet</th>
	<th>Date</th>
</tr>

<? foreach ($messages as $message) { } ?>
</table>
<? } else { ?>
<p>You don't have any messages...</p>
<? } ?>