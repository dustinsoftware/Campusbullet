<script type="text/javascript">
function gouser() {
	userid = document.getElementById("userid").value;
	location.href = "<?=$url_base?>moderator/user/" + userid;
}

function gopost() {
	postid = document.getElementById("postid").value;
	location.href = "<?=$url_base?>moderator/post/" + postid;
}
</script>
<h1>Moderator Tools!</h1>
<p>Hey, cool.&nbsp; You&#39;re in the moderator tools!&nbsp; This section is for the 
elitest of the elite.&nbsp; FYI, all use of this tool is logged, so don&#39;t abuse 
it.</p>
<table>
<tr>
<td style="border-right: 1px white solid">

<h2>Edit a user</h2>
<p>Enter the name or user ID of a user to get information on them.&nbsp; Or, 
leave the box blank to get a list of all the users in the system.</p>
<p><input id="userid" type="text" /> <input type="button" onclick="gouser()" value="  go!  " /></p>
</td>
<td>
<h2>Edit a post</h2>
<p>Enter the ID of a post to edit it, or leave the box blank to view all the 
posts in the system.</p>
<p><input id="postid" type="text" /> <input type="button" onclick="gopost()" value="  go!  " />&nbsp;</p>
</td>
</tr>
</table>



