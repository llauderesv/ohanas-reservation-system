var dateToday = new Date(); 
$(document).ready(function(){
	$("#adate").datepicker({
      minDate: dateToday 
	});
	$("#ddate").datepicker({
    minDate: dateToday 
	 });
    $("#person").hide();
    $("#person2").hide();
    $("#payment").hide();
    $("#price").hide();
    $("#price_label").hide();
    $("#atime").hide();
    $("#dtime").hide();
    $("#atime_label").hide();
    $("#dtime_label").hide();
});
function refno(){
	if (isNaN(document.getElementById('ref_no').value)) {
  		document.getElementById('ref_error').innerHTML = "Invalid reference number";
  		document.getElementById('ref_hidden').value = "Invalid reference number";
	} else {
  		document.getElementById('ref_error').innerHTML = "";
  		document.getElementById('ref_hidden').value = "";
	}
}
function aclear() {
	document.getElementById('adate').value = "";
}
function dclear() {
	document.getElementById('ddate').value = "";
}
  function getDate() {
  	var time = document.getElementById('time');
  	var person = document.getElementById('person');
  	var price = document.getElementById('price');
  	var adates = document.getElementById('adate');
  	var arrival_date = document.getElementById('adate');
  	var arrival_date2 = arrival_date.value;
  	var departure_date = document.getElementById('ddate');
  	var departure_date2 = departure_date.value;
  	var f = 6000;
  	var atime = document.getElementById('atime');
  	var dtime = document.getElementById('dtime');
  	var atime_label = document.getElementById('atime_label');
  	var dtime_label = document.getElementById('dtime_label');
  	var e = 30;
  	var difference_two = person.value - e; 
  	if (time.value == "day_time") {
  		$("#person").fadeOut();
  		$("#person2").fadeOut();
  		$("#price").fadeOut();
  		$("#price_label").fadeOut();
    	$("#atime_label").fadeOut();
    	$("#dtime_label").fadeOut();
  		$("#atime").fadeOut();
    	$("#dtime").fadeOut();
  		price.value = 6000;
  		$("#person").fadeIn();
  		$("#person2").fadeIn();
  		$("#price").fadeIn();
  		$("#price_label").fadeIn();
  		$("#atime_label").fadeIn();
    	$("#dtime_label").fadeIn();
  		$("#atime").fadeIn();
    	$("#dtime").fadeIn();
  		if(difference_two == 0) {
  		 	price.value = 6000;
	  	} else if (difference_two > 0) {
	  		price.value = difference_two * 50 + 6000;
	  	} else if (person.value == 0) {
	  		price.value = 6000;
	  	}
		atime.getAttribute("type");
		atime.setAttribute("type","text");
		atime.value ="8:00 AM";
		atime.readOnly = true;
		dtime.getAttribute("type");
		dtime.setAttribute("type","text");
		dtime.value ="5:00 PM";
	 	dtime.readOnly = true;
  	} else if (time.value == "night_time") {
  		$("#person").fadeOut();
  		$("#person2").fadeOut();
  		$("#price").fadeOut();
  		$("#price_label").fadeOut();
    	$("#atime_label").fadeOut();
    	$("#dtime_label").fadeOut();
  		$("#atime").fadeOut();
    	$("#dtime").fadeOut();
  		price.value = 6500;
  		$("#person").fadeIn();
  		$("#person2").fadeIn();
  		$("#price").fadeIn();
  		$("#price_label").fadeIn();
  		$("#atime_label").fadeIn();
    	$("#dtime_label").fadeIn();
  		$("#atime").fadeIn();
    	$("#dtime").fadeIn();
  		if(difference_two == 0) {
  			price.value = 6500;
	  	} else if (difference_two > 0) {
	  		price.value = difference_two * 50 + 6500;
	  	} else if (person.value == 0) {
	  		price.value = 6500;
	  	} 
	    atime.getAttribute("type");
		atime.setAttribute("type","text");
		atime.value ="7:00 PM";
		atime.readOnly = true;
		dtime.getAttribute("type");
		dtime.setAttribute("type","text");
		dtime.value ="6:00 AM";
		dtime.readOnly = true;
  	} else if (time.value == "days_rent") {
  		atime.getAttribute("type");
	  	atime.setAttribute("type","time");
		atime.readOnly = false;
  		$("#person").fadeOut();
  		$("#person2").fadeOut();
  		$("#price").fadeOut();
  		$("#price_label").fadeOut();
  		$("#atime").fadeOut();
    	$("#dtime").fadeOut();
    	$("#atime_label").fadeOut();
    	$("#dtime_label").fadeOut();
  		price.value = price.value;
  		$("#room_price").fadeIn();
  		$("#person").fadeIn();
  		$("#person2").fadeIn();
  		$("#price").fadeIn();
  		$("#price_label").fadeIn();
  		$("#atime").fadeIn();
    	$("#dtime").fadeIn();
    	$("#atime_label").fadeIn();
    	$("#dtime_label").fadeIn();
  		var number_label = document.getElementById('number_label');
	  	var number_of_days = document.getElementById('number_of_days');
	  	var thisSample4 = document.getElementById('sample4');
	  	var total_price = Number(price.value);
	  	if (sample4.value == "") {
	  		if (person.value > 30) {
	  			price.value = total_price + difference_two * 50;
	  		} 
	  	}
  	} else {
  		$("#person").fadeOut();
  		$("#person2").fadeOut();
  		$("#price").fadeOut();
  		$("#price_label").fadeOut();
  		$("#atime").fadeOut();
    	$("#dtime").fadeOut();
    	$("#atime_label").fadeOut();
    	$("#dtime_label").fadeOut();
   	 	$("#number_label").fadeOut();
    	$("#number_of_days").fadeOut();
  	}
  }
 function getTime() {
  	var adate = document.getElementById('adate');
  	var adates2 = adate.value;
  	var adate_replace = adates2.substr(3,2);
  	var ddates = document.getElementById('ddate');
  	var ddates2 = ddates.value;
  	var ddate_replace = ddates2.substr(3,2);
  	var ddate_year = ddates2.substr(6,7);
  	var adate_year = adates2.substr(6,7);
  	var adate_day = adates2.slice(3,5);
  	var adate_month = adates2.slice(0,2);
  	var thisDate = parseInt(adate_month + adate_day);
  	var total_date = ddate_replace - adate_replace;
  	var time = document.getElementById('time');

  	if (time.value == "day_time") {
  		var total_date = adate_replace - ddate_replace;
  		var year = new Date();
  		var day = new Date();
  		var month = ['1','2','3','4','5','6','7','8','9','10','11','12'];
    	var nowMonth = month[day.getMonth()];
    	var nowDate = parseInt(nowMonth + day.getDate());
    	var thisCalendar = new Date();
    	var nowMonth2 = month[thisCalendar.getMonth()];
    	var thisCalendar2 = nowMonth2 + "/" + thisCalendar.getDate() + "/" + thisCalendar.getFullYear();
	  	//========================================================================================
	  	if (adate.value == thisCalendar2) {
	  		document.getElementById('valid8').innerHTML = "Your arrival date must be 1 day interval";
	  		document.getElementById('sample8').value = "Your arrival date must be 1 day interval";
	  	} else {
	  		document.getElementById('valid8').innerHTML = "";
	  		document.getElementById('sample8').value = "";
	  	}
	  	//========================================================================================
  		if (year.getFullYear() != ddate_year) {
	  		document.getElementById('valid').innerHTML = "Enter a valid year";
	  		sample2.value = "Enter a valid year";
	  	} else {
	  		document.getElementById('valid').innerHTML = "";
	  		sample2.value = "";
	  	}
	  	//========================================================================================
	  	if (year.getFullYear() != adate_year) {
	  		document.getElementById('valid2').innerHTML = "Enter a valid year";
	  		sample3.value = "Enter a valid year";
	  	} else {
	  		document.getElementById('valid2').innerHTML = "";
	  		sample3.value = "";
	  	}
	  	//========================================================================================
	  	if (nowDate > thisDate) {
	  		document.getElementById('valid').innerHTML = "Enter a valid day";
	  		sample2.value = "Enter a valid day";
	  	} else {
	  		document.getElementById('valid').innerHTML = "";
	  		sample2.value = "";
	  	}
	  	//========================================================================================
	  	if (nowDate > thisDate) {
	  		document.getElementById('valid').innerHTML = "Enter a valid day";
	  		sample2.value = "Enter a valid day";
	  	} else {
	  		document.getElementById('valid').innerHTML = "";
	  		sample2.value = "";
	  	}
  		//=========================================================================================
	  	if (adates2.slice(0,2) <= ddates2.slice(0,2)) {
	  		if (total_date > 0 || total_date < 0) {
		  		document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  		sample.value = "Enter a valid departure date";
		  	} else {
		  		document.getElementById('error1').innerHTML = "";
		  		sample.value = "";
		  	}
	  	} else {
	  		if (adates2.slice(0,2) > ddates2.slice(0,2)) {
	  			document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  		sample.value = "Enter a valid departure date";
		  	} else {
		  		document.getElementById('error1').innerHTML = "";
		  		sample.value = "";
		  	}
	  	}
  	//=========================================================================================	
  	} else if (time.value == "night_time") {
  		var adate = document.getElementById('adate');
	  	var adates2 = adate.value;
	  	var adate_replace3 = adates2.substr(0,2);
	  	var ddates = document.getElementById('ddate');
	  	var ddates2 = ddates.value;
	  	var ddate_replace3 = ddates2.substr(0,2);
  		var total_date = ddate_replace - adate_replace;
  		var adate_day = adates2.slice(3,5);
  		var adate_month = adates2.slice(0,2);
  		var thisDate = parseInt(adate_month + adate_day);
  		var year = new Date();
  		var day = new Date();
  		var month = ['1','2','3','4','5','6','7','8','9','10','11','12'];
    	var nowMonth = month[day.getMonth()];
    	var nowDate = parseInt(nowMonth + day.getDate());
    	var thisCalendar = new Date();
    	var nowMonth2 = month[thisCalendar.getMonth()];
    	var thisCalendar2 = nowMonth2 + "/" + thisCalendar.getDate() + "/" + thisCalendar.getFullYear();
  		//=========================================================================================
  		if (adate.value == thisCalendar2) {
	  		document.getElementById('valid8').innerHTML = "Your arrival date must be 1 day interval";
	  		document.getElementById('sample8').value = "Your arrival date must be 1 day interval";
	  	} else {
	  		document.getElementById('valid8').innerHTML = "";
	  		document.getElementById('sample8').value = "";
	  	}
	  	//==========================================================================================
  		if (year.getFullYear() != ddate_year) {
	  		document.getElementById('valid').innerHTML = "Enter a valid year";
	  		sample2.value = "Enter a valid year";
	  	} else {
	  		document.getElementById('valid').innerHTML = "";
	  		sample2.value = "";
	  	}
	  	//=========================================================================================
	  	if (year.getFullYear() != adate_year) {
	  		document.getElementById('valid2').innerHTML = "Enter a valid year";
	  		sample3.value = "Enter a valid year";
	  	} else {
	  		document.getElementById('valid2').innerHTML = "";
	  		sample3.value = "";
	  	}
	  	//============================================================================================
	  	if (nowDate > thisDate) {
	  		document.getElementById('valid').innerHTML = "Enter a valid day";
	  		sample2.value = "Enter a valid day";
	  	} else {
	  		document.getElementById('valid').innerHTML = "";
	  		sample2.value = "";
	  	}
	  	//=============================================================================================
	  	if (adates2.slice(0,2) <= ddates2.slice(0,2)) {
			if (total_date == 1) {
	  			document.getElementById('error1').innerHTML = "";
		  		sample.value = "";
		  	//=========================================================================================
		  	} else if (total_date < 1) {
		  		document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  		sample.value = "Enter a valid departure date";
		  	//=========================================================================================	
		  	} else {
		  		document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  		sample.value = "Enter a valid departure date";
		  	}
	  	} else {
	  		if (adates2.slice(0,2) > ddates2.slice(0,2)) {
	  			document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  		sample.value = "Enter a valid departure date";
		  	} else {
		  		document.getElementById('error1').innerHTML = "";
		  		sample.value = "";
		  	}
	  	}
	  	//=================================================================================================
	  	if (adate_replace == 30) {
	  		//=============================================================================================
		  	if (total_date == -29) {
		  		//=========================================================================================
		  		if (ddate_replace3 == adate_replace3) {
	  				document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  			sample.value = "Enter a valid departure date";
		  		//=========================================================================================	
		  		} else {
					document.getElementById('error1').innerHTML = "";
			  		sample.value = "";
		  		}
		  	//=========================================================================================	
		  	} else {
		  		document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  		sample.value = "Enter a valid departure date";
		  	}
		//=========================================================================================  	
	  	} else if (adate_replace == 31) {
	  		if (total_date == -30) {
	  			//=========================================================================================
		  		if (ddate_replace3 == adate_replace3) {
	  				document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  			sample.value = "Enter a valid departure date";
		  		//=========================================================================================	
		  		} else {
					document.getElementById('error1').innerHTML = "";
			  		sample.value = "";
		  		}
		  	//=========================================================================================	
		  	} else {
		  		document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  		sample.value = "Enter a valid departure date";
		  	}
	  	}
  	} else if (time.value == "days_rent") {
  		//===============================================================================
	  	//===============================================================================
  		var arrivalDate = document.getElementById('adate').value;
  		var departureDate = document.getElementById('ddate').value;
  		var getArrivalDate = arrivalDate.slice(0,5);
  		var repArrivalDate = getArrivalDate.replace('/','');
  		var getDepartureDate = departureDate.slice(0,5);
  		var repDepartureDate = getDepartureDate.replace('/','');
  		var thisDate = new Date();
  		var nowDay = arrivalDate.slice(3,5);
  		var nowMonth = arrivalDate.slice(0,2);
  		var nowDate = parseInt(nowMonth + nowDay);
  		var month = ['1','2','3','4','5','6','7','8','9','10','11','12'];
    	var thisMonth = month[thisDate.getMonth()];
    	var thiDate2 = parseInt(thisMonth + thisDate.getDate());
    	var thisCalendar = new Date();
    	var nowMonth2 = month[thisCalendar.getMonth()];
    	var thisCalendar2 = nowMonth2 + "/" + thisCalendar.getDate() + "/" + thisCalendar.getFullYear();
  		//===============================================================================
	  	//===============================================================================
	  	if (adate.value == thisCalendar2) {
	  		document.getElementById('valid8').innerHTML = "Your arrival date must be 1 day interval";
	  		document.getElementById('sample8').value = "Your arrival date must be 1 day interval";
	  	} else {
	  		document.getElementById('valid8').innerHTML = "";
	  		document.getElementById('sample8').value = "";
	  	}
	  	//==============================================================================================
	  	if (arrivalDate.slice(0,2) <= departureDate.slice(0,2)) {
	  		if (arrivalDate.slice(3,5) > departureDate.slice(3,5)) {
	  			if (nowDay == 31) {
	  				var totalDate = ((repDepartureDate - repArrivalDate) + 1) - 70;
	  				if (totalDate <= 3) {
	  					var price = 12000;
		  				var reservationPrice = price * totalDate;
		  				$("#person").fadeIn();
			  			$("#person2").fadeIn();
			  			document.getElementById('price').value = reservationPrice;
			  			document.getElementById('error1').innerHTML = "";
	  					document.getElementById('sample5').value ="";
	  				} else if(totalDate > 3) {
	  					document.getElementById('error1').innerHTML = "Maximum of 3 days only";
	  					document.getElementById('sample5').value = "Maximum of 3 days only";
	  					document.getElementById('price').value = 0;
	  				} else {
	  					document.getElementById('error1').innerHTML = "";
	  					document.getElementById('sample5').value = "";
	  				}
	  			} else if (nowDay == 30) {
	  				var totalDate = (repDepartureDate - repArrivalDate) - 70;
	  				if (totalDate <= 3) {
	  					var price = 12000;
		  				var reservationPrice = price * totalDate;
		  				$("#person").fadeIn();
			  			$("#person2").fadeIn();
			  			document.getElementById('price').value = reservationPrice;
			  			document.getElementById('error1').innerHTML = "";
	  					document.getElementById('sample5').value ="";
	  				} else if(totalDate > 3) {
	  					document.getElementById('error1').innerHTML = "Maximum of 3 days only";
	  					document.getElementById('sample5').value = "Maximum of 3 days only";
	  					document.getElementById('price').value = 0;
	  				} else {
	  					document.getElementById('error1').innerHTML = "";
	  					document.getElementById('sample5').value = "";
	  				}
	  			}
	  		} else if (arrivalDate.slice(3,5) < departureDate.slice(3,5)) {
	  				var totalDate = repDepartureDate - repArrivalDate;
	  				if (totalDate <= 3) {
	  					var price = 12000;
		  				var reservationPrice = price * totalDate;
		  				$("#person").fadeIn();
			  			$("#person2").fadeIn();
			  			document.getElementById('price').value = reservationPrice;
			  			document.getElementById('error1').innerHTML = "";
	  					document.getElementById('sample5').value ="";
	  				} else if(totalDate > 3) {
	  					document.getElementById('error1').innerHTML = "Maximum of 3 days only";
	  					document.getElementById('sample5').value = "Maximum of 3 days only";
	  					document.getElementById('price').value = 0;
	  				} else {
	  					document.getElementById('error1').innerHTML = "";
	  					document.getElementById('sample5').value = "";
	  				}
	  		} else if (arrivalDate.slice(3,5) == departureDate.slice(3,5)) {
	  			document.getElementById('error1').innerHTML = "Minimum of 1 day only";
	  			document.getElementById('sample5').value = "Minimum of 1 day only";
	  			document.getElementById('price').value = 0;
	  		} else {
	  			document.getElementById('error1').innerHTML = "";
	  			document.getElementById('sample5').value = "";
	  		}
  		} else {
	  		if (arrivalDate.slice(0,2) > departureDate.slice(0,2)) {
	  			document.getElementById('error1').innerHTML = "Enter a valid departure date";
		  		sample.value = "Enter a valid departure date";
		  	} else {
		  		document.getElementById('error1').innerHTML = "";
		  		sample.value = "";
		  	}
	  	}
		//===============================================================================
	  	//===============================================================================
  		if (arrivalDate.slice(0,2) == departureDate.slice(0,2)) {
  			if (arrivalDate.slice(3,5) > departureDate.slice(3,5)) {
  				document.getElementById('valid4').innerHTML = "Invalid departure date";
	  			sample2.value = "Invalid departure date";
		  	} else {
		  		document.getElementById('valid4').innerHTML = "";
		  		sample2.value = "";
		  	}
  		} else if (arrivalDate.slice(0,2) != departureDate.slice(0,2)) {
  			document.getElementById('valid4').innerHTML = "";
		  	sample2.value = "";
  		}
  		//===============================================================================
	  	//===============================================================================
  		if (thiDate2 > nowDate) {
	  		document.getElementById('error').innerHTML = "Enter a valid day of reservation";
	  		sample2.value = "Enter a valid day of reservation";
	  	} else {
	  		document.getElementById('error').innerHTML = "";
	  		sample2.value = "";
	  	}
	  	//===============================================================================
	  	//===============================================================================
  		if (thisDate.getFullYear() != ddate_year) {
	  		document.getElementById('valid').innerHTML = "Year must be present";
	  		sample2.value = "Enter a valid year";
	  	} else {
	  		document.getElementById('valid').innerHTML = "";
	  		sample2.value = "";
	  	}
	  	//===============================================================================
	  	//===============================================================================
	  	if (thisDate.getFullYear() != adate_year) {
	  		document.getElementById('valid2').innerHTML = "Year must be present";
	  		sample2.value = "Enter a valid year";
	  	} else {
	  		document.getElementById('valid2').innerHTML = "";
	  		sample2.value = "";
	  	}
  	}
  }

  function fadeInvalid() {
  	$("#invalid").fadeOut();
  }

  function validatePerson() {
  	var regNum = /^[0-9]+$/;
  	if (!regNum.test(person.value)) {
  		document.getElementById('error13').innerHTML = "Enter a valid number";
  		document.getElementById('sample13').value = "Enter a valid number";
  	} else {
  		document.getElementById('error13').innerHTML = "";
  		document.getElementById('sample13').value = "";
  	}

  	if (isNaN(person.value) || person.value == "") {
  		$("#person").fadeIn();
  		document.getElementById('error2').innerHTML = "Enter a number only";
  		sample4.value = "Enter a number only";
  	} else {
  		if (person.value > 100) {
  			document.getElementById('error2').innerHTML = "Maximum of 100 person only";
  			sample4.value = "Maximum of 100 person only";
  		} else {
  			document.getElementById('error2').innerHTML = "";
  			sample4.value = "";
  		}
  	}
  }

  function validateTime() {
  	if (document.getElementById('atime').value == "") {
  		document.getElementById('error3').innerHTML = "Enter a arrival time";
  	} else {
  		document.getElementById('error3').innerHTML = "";
  	}
  }

  function validateTime2() {
  	if (document.getElementById('dtime').value == "") {
  		document.getElementById('error4').innerHTML = "Enter a departure time";
  	} else {
  		document.getElementById('error4').innerHTML = "";
  	}
  }

  function validateRent() {
  	if (time.value == "") {
  		document.getElementById('error5').innerHTML = "Enter your days of rent";
  	} else {
  		document.getElementById('error5').innerHTML = "";
  	}
  }

   function thisTime() {
  	var daysOfRent = document.getElementById('time');
  	if (daysOfRent.value == 'days_rent') {
  		var arrivalTime = document.getElementById('atime');
  		var departureTime = document.getElementById('dtime');
  		if (arrivalTime.value != "") {
	  		arrivalTime.getAttribute("type");
		  	arrivalTime.setAttribute("type","time");
			arrivalTime.readOnly = false;
			departureTime.value = arrivalTime.value;
			departureTime.getAttribute("type");
			departureTime.setAttribute("type","time");
			departureTime.readOnly = true;
  		} else {
  			departureTime.value = null;
  			departureTime.getAttribute("type");
			departureTime.setAttribute("type","text");
			departureTime.readOnly = true;
  		}
  	}

  }