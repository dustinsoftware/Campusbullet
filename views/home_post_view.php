<style type="text/css">
.bold {
	font-weight: bold;
}
</style>
<h1><?=$post_title ?></h1>
<hr />
<table>
<tr><td>Price:</td><td><?=$post_price?></td></tr>
<tr><td>Condition:</td><td><?=$post_condition?></td></tr>
</table>

<p><span class="bold">Description of item:</span><br />
<?=$post_description ?>
</p>

<? if ( ! $preview) { ?>
<? if ($is_owner) { ?>
<p>You are the owner of this post.</p>
<ul>
	<li><a href="<?= $link_edit ?>">Edit or disable this post</a></li>
	<li><a href="<?= $link_prev ?>">Go back to the post viewer</a></li>
</ul>
<? } else { ?>
<p>What next? </br>
<ul>
	<li><a href="<?= $link_want ?>">I want this item!</a></li>
	<li><a href="<?= $link_report ?>">Report this item..</a></li>
	<li><a href="<?= $link_prev ?>">Go back to the post viewer</a></li>
</ul>
</p>
<? } ?>
<? } ?>