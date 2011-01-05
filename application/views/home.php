<h1>Select a category to begin</h1>
<p class="info">masterslist v1.0 Beta. (C)2010 Dustin Masters.<br />
Please note I have every intention of 
changing the icons you see below, just have to get around to it :)</p>
<div id="categories">
<? foreach($categories as $category) { ?>
<a class="button" href="<?=$url_base?>home/category/<?=$category['name']?>">
<img src="<?=$url_base?>images/<?=$category['name']?>.png" alt="" />
<?=$category['prettyname']?>
</a>
<? } ?>
</div>
