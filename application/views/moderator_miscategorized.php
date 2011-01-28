<h1>Move Post to Another Category</h1>

<p>Post to move: <strong><?=$post_name?></p>

<p>What category do you want to move it to?</p>

<form action="" method="post">

<select name="category" style="width: 200px" onchange="showhide()">
	<? foreach ($categories as $category) {		
		if ($post_category == $category['id']) {
			echo "<option selected=\"selected\" value=\"$category[id]\">$category[prettyname]</option>\r\n";
		} else {
			echo "<option value=\"$category[id]\">$category[prettyname]</option>\r\n";
		}
			
	} ?>	
	</select>&nbsp; 
<input type="submit" name="action" value="Change category" />
	
</form>
