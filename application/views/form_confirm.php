<script type="text/javascript">
function goback() {
	location.href = "<?=$goback?>";
}
</script>
<h1>Are you sure you want to do that?</h1>

<? 
if ($action == "post_disable")
	$message = "You are about to disable a post.&nbsp; You can always re-enable it if you change your mind.";
elseif ($action == "post_enable")
	$message = "You are about to re-enable a post that was disabled.";
else
	$message = "";
?>

<p><?=$message?></p>

<form action="" method="POST">
<? foreach ($form_items as $name => $item) { 
	echo "<input type=\"hidden\" name=\"$name\" value=\"$item\" />\n";
} ?>
<input type="submit" name="confirmed" value="Yes, I'm sure." />
<input type="button" onclick="goback()" value="No, take me back!" />

</form>