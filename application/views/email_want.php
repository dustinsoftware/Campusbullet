<html>
<body>

<h1>Hi from masterslist!</h1>

<p><span style="font-weight:bold"><?= $username ?></span> wants to buy your <span style="font-weight:bold"><?=$post_name?></span>!  They said: </p>

<p><pre><?= $message ?></pre></p>

<p>The person's email address is <a href="mailto:<?=$sender_email?>"><?=$sender_email?></a>.&nbsp; Please contact them at this address (hitting the reply button should automatically fill in their email address in the To: field).

<p>If you want to stop receiving emails regarding this item, please take down the post by clicking <a href="<?=$base?>post/edit/<?=$id?>">here</a>.
&nbsp; Please note that your post will automatically expire after 30 days from the date of initial posting, unless you repost it to the top.&nbsp; Thanks for using masterslist!</p>


</body>
</html>