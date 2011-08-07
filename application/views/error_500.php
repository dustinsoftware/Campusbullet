<script type="text/javascript">
window.addEvent('domready', function() {
	var request = new Request.HTML({url:'<?=URL::base()?>ajax/bugreport'}).post("page=" + encodeURIComponent(location.href))
	
	$('fixstatus').innerHTML = "The problem has been automatically reported.&nbsp; We'll try to have it fixed soon.";
	$('fixstatus').innerHTML = request.response.text;
});
</script>

<h1>Congratulations!</h1>

<p>You just caused the server to crash in a very serious way.&nbsp; Either we're 
doing some maintenance, or there is a bug in the site.</p>
<p id="fixstatus">Hang on while we automatically report the crash to the code monkeys...</p>
<p><a href="<?= URL::base() ?>">Return to the main page</a></p>