<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
<link href="<?=$url_base?>iwebkit/css/style.css" rel="stylesheet" media="screen" type="text/css" />
<script src="<?=$url_base?>javascript/functions.js" type="text/javascript"></script>
<title>Sexy Start Page</title>

<style type="text/css">
.hidden {
	display:none;
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

<body>

<div id="topbar" class="black">
	<div id="title">Sexy Start Page</div>
</div>
<div id="content">
	<span class="graytitle">Campus Announcements:</span>
	
	<ul class="pageitem">
		<? foreach ($announcements as $announcement) {
			echo "<li class=\"textbox\"><a href=\"javascript:showhide($announcement[id])\">$announcement[title]</a><div class=\"hidden announcement\" id=\"$announcement[id]\">$announcement[description]</div></li>";
		} ?>
	</ul>
	
	<span class="graytitle">Helpful Links:</span>
	<ul>
		<li><a href="http://www.letu.edu/opencms/opencms/_Student-Life/handbook.pdf">Student Handbook</a></li>
		<li>
		<a href="http://www.letu.edu/opencms/opencms/_Portal/current_students/phoneDirectory/index.html">Faculty/Staff &amp; Department Directories</a></li>
		<li>	
		<a href="http://www.letu.edu/opencms/opencms/homepage-links/student-resources/studir.lnk">Student Directory</a></li>
	</ul>
	
	<ul class="pageitem">
	<li class="textbox">
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
<a href="https://tutortrac.letu.edu/TutorTrac/Default.html">TutorTrac</a></p>
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
Live Chapel Video </a></p></li>	
	</li>
	</ul>
	<p>

	</ul>
</div>
<div id="footer">
	<!-- Support iWebKit by sending us traffic; please keep this footer on your page, consider it a thank you for our work :-) -->
	<a class="noeffect" href="http://snippetspace.com">Powered by iWebKit</a></div>

</body>

</html>
