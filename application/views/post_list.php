<script type="text/javascript" >
function createpost() {
	location.href = "<?=$url_base?>post/new";
}

//made some javascript boxes to make the process feel nicer.
function postdisable(id) {
	var confirmed = confirm("Are you sure you want to disable that post?");
	
	if (confirmed) {
		 var form = new Element('form',
			{method: 'post', action: '<?=$url_base?>post/disable/' + id});
		 form.adopt(new Element('input',
			 {name: 'confirmed', value: 'true', type: 'hidden'}));
		 $(document.body).adopt(form);
		 form.submit();
	}
	
	return false;
}
function postdelete(id) {
	var confirmed = confirm("Are you sure you want to delete that post?  This cannot be undone.");
	
	if (confirmed) {
		 var form = new Element('form',
			{method: 'post', action: '<?=$url_base?>post/delete/' + id});
		 form.adopt(new Element('input',
			 {name: 'confirmed', value: 'true', type: 'hidden'}));
		 $(document.body).adopt(form);
		 form.submit();
	}
	
	return false;
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
		array_push($options, array(
			'link' => "post/edit/$post[id]",
			'name' => 'edit',
			'id' => $post['id']));
	if ($post['disabled'] == 0)
		array_push($options, array(
			'link' => "post/disable/$post[id]",
			'name' => 'disable',
			'id' => $post['id']));
	array_push($options, array(
		'link' => "post/delete/$post[id]",
		'name' => 'delete',
		'id' => $post['id']));
		
	echo "<td style=\"text-align: center\">";
	$first = true;
	foreach ($options as $option) {
		$link = $option['link'];
		$name = $option['name'];
		$postid = $option['id'];
		if ($first)				
			$first = false;
		else
			echo " | ";
		if ($name == "disable")			
			echo "<a onclick=\"return postdisable($postid)\" href=\"" . $url_base . "$link\">$name</a>";
		elseif ($name == "delete")
			echo "<a onclick=\"return postdelete($postid)\" href=\"" . $url_base . "$link\">$name</a>";
		else		
			echo "<a href=\"" . $url_base . "$link\">$name</a>";
	}			
	echo "</td>";

	echo "</tr>\n";
} ?>

</table>

<? } else { ?>
<p>Hey, you don't have any posts!&nbsp; Why don't you <a href="<?=$url_base?>post/new">go post something!</a></p>
<? } ?>