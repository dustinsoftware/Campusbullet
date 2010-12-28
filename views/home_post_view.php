<style type="text/css">
.bold {
	font-weight: bold;
}
</style>
<? if ( ! $preview) { ?>

<h2>Post viewer!</h2>

<p>Here's what the sorry sap had to say about what they posted..</p>

<hr />

<? } ?>
<h1><?=$post_title ?></h1>
<hr />
<p>Some quick details: <br />
<span class="bold">Price: </span><?=$post_price ?><br />
<span class="bold">Condition: </span><?=$post_condition ?><br />
</p>

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