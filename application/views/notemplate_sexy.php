<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>super start page</title>
<style type="text/css">
body {
	background: #244369;
	color: white;	
	font-family:Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
}
a {
	color:white;
	text-decoration:none;
}
a:hover {
	text-decoration:underline;
}
.hidden {
	display:none;
}
#announcements {
	width: 90%;
	margin-left:auto;
	margin-right:auto;
	margin-top: 20px;
}
#announcements td {
	vertical-align: top;
	padding: 10px;
	
}
.announcement {
	background: white;
	color: black;
	border: 1px solid black;
	padding: 5px;
}
.announcement p {
	margin-top: 0px;
}
.announcement a {
	color:darkblue;
}
</style>
<script type="text/javascript">
function showhide(id) {
	var item = document.getElementById(id);
	if (item.className == "hidden announcement")
		item.className = "announcement";
	else
		item.className = "hidden announcement";
}
</script>
</head>

<body onload="document.forms[0].elements[0].focus();">
<div style="text-align:center;margin-top:50px;">

<h1>Super Start Page</h1>
<p><a target="_blank" href="http://mail.letu.edu">email</a> | <a  target="_blank" href="http://courses.letu.edu">blackboard</a> | 
<a  target="_blank" href="http://facebook.com">facebook</a> | <a  target="_blank" href="http://campusbullet.net">campusbullet</a></p>
<form action="http://www.google.com/search" method="get">
The great google: <input type="text" name="q" />&nbsp;<input type="submit" value="  do it  "/>
</form>
</div>
<div id="announcements">
<table>
	<tr>
		
		<th>Today at Saga:</th>
		<th>Announcements:</th>		
	</tr>
	<tr>
		<td>
			<? if ($cafe_menu) echo "<table>$cafe_menu</table>"; else echo "No menu found for today."; ?>
		</td>
		<td style="width: 50%">			
			<ul>
			<? foreach ($announcements as $announcement) {
				echo "<li><a href=\"javascript:showhide($announcement[id])\">$announcement[title]</a><div class=\"hidden announcement\" id=\"$announcement[id]\">$announcement[description]</div></li>";
			} ?>
			</ul>
		</td>
		
	</tr>
</table>
<table>
	<tr>
		<th>Helpful Stuff:</th>
	</tr>
	<tr>
		<td style="text-align: center"><a href="http://www.letu.edu/opencms/opencms/_Student-Life/handbook.pdf">Student Handbook</a> | 
		<a href="http://www.letu.edu/opencms/opencms/_Portal/current_students/phoneDirectory/index.html">Faculty/Staff &amp; Department Directories</a> | 
		<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/studir.lnk">Student Directory</a></td>
	</tr>
	<tr>
		<td>
		<p>
<strong>Academic Resources <br />
</strong>
<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/catalog.lnk">
Catalog</a> |
<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/coursesched-trad.lnk">
Class Listing (Traditional Program)</a> |
<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/coursesched-nontrad.lnk">
Class Listing (GAPS Programs)</a> |
<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/lusa.lnk">
LUSA</a>&nbsp;|
<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/chapelattendance.lnk">
Chapel Attendance</a> |
<a href="http://www.letu.edu/opencms/opencms/_Academics/library/index.html">
Library</a> |
<a href="http://www.letu.edu/opencms/opencms/_Academics/academicRecords/transcripts/index.html">
Transcript Requests</a> |
<a href="https://tutortrac.letu.edu/TutorTrac/Default.html">TutorTrac</a></li></p>
<p><strong>Campus Resources</strong><br />
<a href="http://www.letu.edu/opencms/opencms/fac-staff/post-office/index.html">
Mail Center Information</a>&nbsp;|
<a href="http://www.letu.edu/opencms/opencms/_Student-Life/residence-life/DiningHall.html">
Dining Services</a>&nbsp;|
<a href="http://www.cafebonappetit.com/letu/cafes/thecafe/weekly_menu.html">Cafe 
Menu</a>&nbsp;|
<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/campusservices.lnk">
Directory of Campus Services</a> |
<a href="http://www.letu.edu/opencms/opencms/_Student-Life/campus-safety/Campus_Lock-Up_Schedule.html">
Longview Campus Building Operation Hours</a> |
<a href="http://www.letu.edu/opencms/opencms/_Other-Resources/_Community-and-Media/employment_opps/student/index.jsp">
On- &amp; Off-Campus Jobs</a>&nbsp;|
<a href="http://www.letu.edu/opencms/opencms/_Other-Resources/Bookstore/index.html">
University Bookstore</a>&nbsp;|
<a href="http://www.letu.edu/opencms/opencms/_Portal/current_students/movietickets.html">
Movie Tickets and Local Showtimes</a></p>
<p><strong>Event &amp; Scheduling Resources</strong>
<br />
<a href="http://www.letu.edu/opencms/opencms/cal">Calendar</a> |
<a href="http://www.letu.edu/opencms/export/sites/default/_Academics/academicRecords/documents/Spring_2011_Final_Exam_Schedule_-_Final.pdf">
Finals Schedule (Spring 2011)</a> |
<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/abbottbus.lnk">
Abbott Center Bus&nbsp;Schedule</a> | <a href="http://astraweb.letu.edu">On-Campus 
Facilities Reservations</a>&nbsp;|
<a href="http://www.letu.edu/opencms/opencms/_Student-Life/spiritual-life/chapel/liveChapel.lnk">
Live Chapel Video </a></p>
</td>
	</tr>
</table>
</div>
<p><small>(Jon is awesome cause he got me a 5 layer burrito.)</small></p>
</body>

</html>
