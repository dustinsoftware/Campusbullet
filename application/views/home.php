<h1>Select a category to begin</h1>
<p class="info">The Campus Bullet v1.0 Beta. (C)2010 Dustin Masters.<br />
Please report ANY bugs with the system, and make suggestions as well using the same tool :)</p>
<div id="categories">
<? foreach($categories as $category) { ?>
<a class="button" href="<?=$url_base?>home/category/<?=$category['name']?>">
<img src="<?=$url_base?>images/<?=$category['name']?>.png" alt="" /><br />
<?=$category['prettyname']?>
</a>
<? } ?>
</div>
