<script type="text/javascript" >
function createpost() {
	location.href = "<?=$url_base?>post/new";
}
</script>

<h1>Your posts!</h1>
<p><input type="button" value="Create a new post" onclick="createpost()" /></p>
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
	if ($post['disabled'] == 2)
		echo "<td><a href=\"" . $url_base . "home/view/$post[id]\">$post[name]</a></td>";
	else
		echo "<td><a href=\"" . $url_base . "home/view/$post[id]\">$post[name]</a> (<a href=\"" . $url_base . "post/edit/$post[id]\">edit</a>)</td>";
	echo "<td>$post[timestamp]</td>";
	echo "<td>" . $post_status_codes[$post['disabled']] . "</td>";
	echo "</tr>\n";
} ?>

</table>

<? } else { ?>
<p>Hey, you don't have any posts!&nbsp; Why don't you <a href="<?=$url_base?>post/new">go post something!</a></p>
<? } ?>