<h1>Select a category to begin</h1>
<div id="categories">
<? foreach($categories as $category) { ?>
<div class="button"><a href="<?=$url_base?>home/category/<?=$category['name']?>">
<img src="<?=$url_base?>images/<?=$category['name']?>.png" alt="" />
<?=$category['prettyname']?></a>
</div>
<? } ?>
</div>
