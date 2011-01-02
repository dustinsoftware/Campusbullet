<h1>Your posts!</h1>

<? if ($my_posts) { ?>
<table>
<tr>
	<th>ID</th>
	<th>Post title</th>
	<th>Timestamp</th>
	<th>Status</th>
</tr>
<? foreach ($my_posts as $post) {
	echo "<tr>";
	echo "<td>$post[id]</td>";
	echo "<td><a href=\"" . $url_base . "post/edit/$post[id]\">$post[name]</a></td>";
	echo "<td>$post[timestamp]</td>";
	if ($post['disabled'] == 0)
		echo "<td>Active!</td>";
	elseif ($post['disabled'] == 1)
		echo "<td>Inactive</td>";	
	elseif ($post['disabled'] == 2)
		echo "<td>Flagged</td>";
	elseif ($post['disabled'] == 3)
		echo "<td>Expired</td>";
	else
		echo "<td>Unknown status</td>";
		
	echo "</tr>\n";
} ?>

</table>

<? } else { ?>
<p>Hey, you don't have any posts!&nbsp; Why don't you <a href="<?=$url_base?>account/newpost">go post something!</a></p>
<? } ?>