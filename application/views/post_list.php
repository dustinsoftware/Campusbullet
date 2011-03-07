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
	<th>Post Date</th>
	<th>Post title</th>
	<th>Status</th>
	<th>Actions</th>
	
</tr>
<? foreach ($my_posts as $post) {
	echo "<tr>";
	$date = date("m-d-Y", strtotime($post['timestamp']));
	echo "<td>$date</td>";
	echo "<td><a href=\"" . $url_base . "home/view/$post[id]\">$post[name]</a></td>";
	echo "<td>" . $post_status_codes[$post['disabled']] . "</td>";
	
	$options = array();
	if ($post['disabled'] == 0 || $post['disabled'] == 1 || $post['disabled'] == 3)		
		$options += array("post/edit/$post[id]" => 'edit');
	if ($post['disabled'] == 0)
		$options += array("post/disable/$post[id]" => 'disable');		
	$options += array("post/delete/$post[id]" => 'delete');
		
	echo "<td style=\"text-align: center\">";
	$first = true;
	foreach ($options as $link => $name) {
		if ($first)				
			$first = false;
		else
			echo " | ";
		echo "<a href=\"" . $url_base . "$link\">$name</a>";
	}			
	echo "</td>";

	echo "</tr>\n";
} ?>

</table>

<? } else { ?>
<p>Hey, you don't have any posts!&nbsp; Why don't you <a href="<?=$url_base?>post/new">go post something!</a></p>
<? } ?>