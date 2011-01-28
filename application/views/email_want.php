<html>
<body>

<h1>Hi from The Campus Bullet!</h1>

<? if ($wanted) { ?>
<p><span style="font-weight:bold"><?= $username ?></span> wants to sell their <span style="font-weight:bold"><?=$post_name?></span> to you!  They said: </p>
<? } else { ?>
<p><span style="font-weight:bold"><?= $username ?></span> wants to buy your <span style="font-weight:bold"><?=$post_name?></span>!  They said: </p>
<? } ?>

<p><pre><?= $message ?></pre></p>

<p>The person's email address is <a href="mailto:<?=$sender_email?>"><?=$sender_email?></a>.&nbsp; Please contact them at this address (hitting the reply button should automatically fill in their email address in the To: field).

<p>If you want to stop receiving emails regarding this item, please take down the post by clicking <a href="<?=$base?>post/edit/<?=$id?>">here</a>.
&nbsp; Please note that your post will automatically expire after 30 days from the date of initial posting, unless you repost it to the top.&nbsp; Thanks for using The Campus Bullet!</p>

<p>Receiving abusive messages from this user?&nbsp; Forward this message to <a href="mailto:abuse@campusbullet.net">abuse@campusbullet.net</a> and we'll take care of it.</p>

</body>
</html>