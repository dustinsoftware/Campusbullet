<h1>Manage your account</h1>
<? if ($message) { ?>
<p class="info"><?=$message?></p>
<? } ?>

<form action="" method="POST">
<h2>Change email</h2>
<p>You can change your email address if you want to receive notifications somewhere else.&nbsp; That email address will be sent a confirmation email to make sure you own it.</p>
Your email address: <input type="textbox" name="email" value="<?=$email_address?>" style="width: 250px;"/>&nbsp; <input type="submit" name="changemail" value="Change my email address" />
</form>

<form action="" method="POST">
<h2>Deactivate account</h2>
<p>You can disable your account by clicking the button below.&nbsp; Please note that ALL of your posts will become inactive if you do so.</p>
<input type="checkbox" name="acknowledged" value="yes" />Yes, I understand that my posts will become inactive if I disable my account.<br /><br />
<input type="submit" name="disable" value="De-activate my account" />

</form>