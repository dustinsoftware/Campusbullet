<h1>Preview your post!</h1>

<p>Below is what your post will look like when published:</p>

<?=$post_preview ?>

<hr />

<form action="" method="POST">
	<input type="hidden" name="title" value="<?=$post_title?>" />
	<input type="hidden" name="condition" value="<?=$post_condition?>" />
	<input type="hidden" name="price" value="<?=$post_price?>" />
	<input type="hidden" name="description" value="<?=$post_description?>" />
	<input type="hidden" name="category" value="<?=$post_category?>" />
	<input type="hidden" name="isbn" value="<?=$post_isbn?>" />
	<input type="submit" name="confirmed" value=" This looks great! " />
	<input type="submit" name="edit" value="I messed up, let me make some changes."  />
</form>