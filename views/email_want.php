<html>
<body>

<h1>Hi from the MasterList!</h1>

<p><span style="font-weight:bold"><?= $username ?></span> wants to buy your <span style="font-weight:bold"><?=$post_name?></span>!  They said: </p>

<p><pre><?= $message ?></pre></p>

<p>The person's email address is <a href="mailto:<?=$sender_email?>"><?=$sender_email?></a>.&nbsp; Please contact them at this address (so, don't reply to this email).

<p>If you want to stop receiving emails regarding this item, please take down the post by clicking <a href="<?=$base?>account/posts/<?=$id?>">here</a>.
&nbsp; Please note that your post will automatically expire after 30 days from the date of initial posting.&nbsp; Thanks for using the MasterList!</p>


</body>
</html>