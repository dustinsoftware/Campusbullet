<h1>About The Campus Bullet (v<?=$version?>)</h1>

<p>The Campus Bullet was started in August 2010, when it was time to start 
purchasing textbooks.&nbsp; I wanted to look for used textbooks to buy from 
people, but soon discovered there was no centralized place to look for used 
books, other than bugging my friends and asking them if they had taken any of 
the classes I was about to.&nbsp; So, The Campus Bullet was born (although it 
didn&#39;t get coded until that Christmas break).</p>
<p>For you computer geeks out there, The Campus Bullet is built on Kohana, PHP, and 
MySQL running on Apache 2.2 on a linux box in a closet somewhere.</p>
<p>Site Credits:</p>
<ul>
	<li>Dustin Masters - Site design and programming</li>
	<li>Becca Masters - Category icons/site logo (and general artistic advisor)</li>
	<li>David Nemati - Legal/senate advisor</li>	
</ul>
<p>Beta Testers:</p>
<ul>
	<li>Katie Masters</li>
	<li>Alan Masters</li>
	<? foreach ($beta_testers as $user) echo "<li>$user[username]</li>\r\n"; ?>
</ul>
<p>Thanks for using The Campus Bullet!</p>



<a href="<?=$url_base?>help">Check out more help documents</a>
