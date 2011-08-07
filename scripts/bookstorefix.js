function checkPage() {
	if (location.href.indexOf("bkstr.com") != -1) {
		scrape();
	} else if (location.href.indexOf("https://cxweb.letu.edu/cgi-bin/student/booknow.cgi") != -1) {
		alert("Please click the Purchase Books button to continue.");
	} else {
		if (confirm("Hold up!  You are not on the bookstore textbook page.  Press OK to be taken to LETU's website, where you can log in and view your required books.")) {
			location.href = "https://cxweb.letu.edu/cgi-bin/student/booknow.cgi";
		}
	}
}

function scrape() {
	var pagesource = document.body.innerHTML;
	
	//parse the html character by character
	var pagearray = pagesource.split("");
	var isbn = "";
	
	var currentnumberstack = "";
	var currentlength = 0;
	
	for (var i = 0; i < pagearray.length; i++) {
		var currentchar = pagearray[i];

		if (currentchar == "-") {
			continue;
		}
		
		if (isNumeric(currentchar)) {
			currentnumberstack = currentnumberstack + currentchar;
			currentlength++;
		} else {
			//we might have hit the end of the ISBN, do a check if it's 10 or 13 characters long.

			if (is_isbn_valid(currentnumberstack)) {
				if (isbn.indexOf(currentnumberstack) == -1) {
					if (isbn != "") {
						isbn += ",";
					}
					
					isbn += currentnumberstack;
				}
			}
			currentnumberstack = "";
			currentlength = 0;
		}
	}
	
	if (isbn == "") {
		alert("No valid ISBNs were found on the current page.");
	} else {
		window.location = "http://localhost/powersearch?isbn=" + isbn;
	}
}

function isNumeric (number) {
	var regex = /^\s*\d+\s*$/;
	return String(number).search (regex) != -1
}


function is_isbn_valid(number){
	//adapted from wikipedia: http://en.wikipedia.org/wiki/International_Standard_Book_Number
	if (number.length == 10) {
		var check = 0;
	    for (var i = 0; i < 9; i++) {
	    	check += (10 - i) * parseInt(number.substring(i, i+1));
	    }
	    var t = parseInt(number.substring(9,10));
	    if (t == 'x' || t == 'X')
	    	check += 10;
	    else
	    	check += t;
	    
		if (check % 11 == 0)
			return true;	
	} else if (number.length == 13) {
		var check = 0;
	    for (var i = 0; i < 13; i += 2) {
	    	check += parseInt(number.substring(i, i+1));
	    }
	    for (var i = 1; i < 12; i += 2) {
	    	check += 3 * parseInt(number.substring(i, i+1));
	    }
	    if (check % 10 == 0)
	    	return true;
	    	
	} else {
		return false;
	}
}



checkPage();