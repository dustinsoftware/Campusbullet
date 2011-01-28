<h1>Ban an IP Address from Registering</h1>
<? if ($message): ?><p class="info"><?=$message?></p><? endif; ?>
<? if ($error): ?><p class="error"><?=$error?></p><? endif; ?>

<p>IP Address to ban: <?=$ip?></p>

<p>To ban that address, click the button below.&nbsp; Users from that address will still be able to log in,
but no new registrations will be accepted.</p>

<form action="" method="post">
<? if ( ! $banned): ?><input type="submit" name="action" value="Ban <?=$ip?>" /><? else: ?>
<input type="submit" name="action" value="Unban <?=$ip?>" />
<? endif; ?>
</form>

<p>What next?</p>
<ul>
<li><a href="<?=$url_base?>admin">Admin toolbox</a></li>
<li><a href="<?=$url_base?>moderator">Mod toolbox</a></li>
<li><a href="<?=$url_base?>home">Go back home</a></li>
</ul>