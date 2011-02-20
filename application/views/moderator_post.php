<h1>Moderator Tools: Manage a Post</h1>
<p>Note: To edit the post for content, please edit the post using the post edit tool and notify the user of the change with a message.</p>
<table>
	<tr>
		<td>Post ID:</td>
		<td><?=$post_id?></td>
	</tr>
	<tr>
		<td>Post owner:</td>
		<td><a href="<?=$url_base?>moderator/user/<?=$owner_id?>"><?=$owner_name?></a></td>
	</tr>
	<tr>
		<td>Current post status:</td>
		<td><?=$post_status_codes[$post_disabled] ?></td>			   
	</tr>
</table>

<? if ($post_disabled == 0): ?>
<p>This post is currently active.&nbsp; To flag it, press the button below.&nbsp; You will then be taken to
the message send screen where you can explain to the user how their post violated the terms of use.</p>
<form method="post" action="">
Change status to: <select name="disabled"><option value="2">Flagged</option><option value="1">Inactive</option></select> 
<input type="submit" name="confirm" value="Do it" />
</form>
<? elseif ($post_disabled == 1): ?>
<p class="info">This post has been disabled by the user.&nbsp; They must re-enable it for it to become active on the site.</p>
<? elseif ($post_disabled == 2): ?>
<p class="error">This post has been previously flagged.&nbsp; It cannot be re-enabled (the poster must create a new post).</p>
<? endif; ?>