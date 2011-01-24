<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Hi from the Campus Bullet!</title>
</head>

<body>
<h1>Hi from the Campus Bullet!</h1>
<p>Heads up! Your post, <a href="<?=$link_post?>"><?=$post_title?></a>, is about to expire!&nbsp; Unless you do something, it 
will disappear from the site in 3 days.&nbsp; So, you have two options.</p>
<p><strong>Option number 1:</strong> <a href="<?=$link_repost?>">Click here</a> to repost your post to the top.&nbsp; 
The date posted will be changed to today&#39;s date, and it&#39;ll stay active for another 30 
days.&nbsp; <?if ($wanted): ?>If you haven&#39;t found whatever it was you were 
looking for,<? else: ?>If you still want to sell whatever it is you&#39;re selling,<? endif; ?> this is the 
recommended option.</p>
<p><strong>Option number 2: </strong>Sit back and be lazy and we&#39;ll remove the 
post for you (<a href="<?=$link_disable?>">or click here to disable it</a>).&nbsp; If you pick this route, you&#39;ve either <?if ($wanted):?>found whatever it was you were looking for<? else: ?>sold whatever it is 
you were selling<? endif; ?>, or you just don&#39;t care anymore.&nbsp; <? if ( ! $wanted) : ?>Don&#39;t expect to be 
selling that <?=$post_title?>&nbsp;anytime soon, though!<? endif; ?></p>
<p>We recommend option number 1.&nbsp; Just a matter of opinion.</p>
<p>Thanks for using the Campus Bullet!</p>
</body>

</html>
