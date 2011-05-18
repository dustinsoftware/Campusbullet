<h1>Email Test</h1>

<p>Use this screen to make sure the email functionality of the system is working correctly.&nbsp; 
It will send all test messages to <?=$admin_email?>.</p>

<form action="<?=URL::base()?>contact/message" method="post">
<input type="hidden" name="action" value="message" />
<input type="hidden" name="message" value="The email system is functioning correctly." />
<input type="hidden" name="to" value="<?=$admin_name?>" />
<input type="submit" value="Send Normal Message" />
</form>