<h1>Your account has been disabled!</h1>
<? if ($message) { ?>
<p>Your account has been disabled for the following reason:</p>
<p><pre><?=$message?></pre></p>
<p>This action was performed by <?=$moderator_name?>.</p>
<? } ?>

<p>You&#39;re seeing this particular error because you somehow violated the terms of 
use.&nbsp; Accounts that are disabled can be re-enabled after one week has 
passed, but only after a moderator decides that you deserve to have your acount 
re-activated.</p>
<p>If you want to read the terms of use, just click here.</p>
<p>Please contact <a href="mailto:bullet_abuse@dustinsoftware.com">
bullet_abuse@dustinsoftware.com</a> if you have any questions.</p>
