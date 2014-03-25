$(function() {

	$('#dailyio-datepicker').datepicker({'setValue':$('#dailyio-datepicker').attr('data-date'), 'format':'yyyy-mm-dd'})
		.on('changeDate', function(ev){
			var locpath = window.location.pathname;

			var locpathArray = locpath.split('/');
			var pageUrl = locpathArray[1];

			var selDate = ev.date;
			var selDateStr = "";
			selDateStr+= ev.date.getUTCFullYear();
			selDateStr+= '-'+(parseInt(ev.date.getUTCMonth())+1);
			selDateStr+= '-'+ev.date.getUTCDate();
			window.location = "/"+pageUrl+"/"+$('#dailyio-datepicker').attr('data-page-hash')+"/"+selDateStr;
    	});
});

function timeToMs(hours, minutes) {
	var ms = 0;
	var oneMin = 60000;

	hours = parseInt(hours);
	minutes = parseInt(minutes);

	if(minutes == 30) {
		ms = 30 * oneMin;
	}

	ms = ms + (hours * oneMin * 60);

	return ms;
}

function msToTime(ms) {
	var x = ms / 1000;
	var seconds = Math.floor(x % 60);
	x /= 60;
	var minutes = Math.floor(x % 60);
	x /= 60;
	var hours = Math.floor(x % 24);
	x /= 24;
	var days = Math.floor(x);

	if(seconds < 10) {
		seconds = "0"+seconds;
	}
	var timeStr = "00:00:"+seconds;

	if(minutes >= 0) {
		if(minutes < 10) {
			minutes = "0"+minutes;
		}
		timeStr = "00:"+minutes;
	}

	if(hours >= 0) {
		if(hours < 10) {
			hours = "0"+hours;
		}
		timeStr = hours+":"+minutes;
	}

	if(days > 0) {
		var dayStr = "day";
		if(days > 1) {
			dayStr = "days";
		}
		timeStr = days+" days, "+hours+":"+minutes;
	}
	return timeStr;
}

function createTimeSelect() {
	var minArray = ['00','30'];
	var $select = $('<select id="time-select" class="time-select"><option value="">Select</option></select>');

	$select.append("<option value='"+timeToMs(0, 5)+"'>00:05</option>");
	$select.append("<option value='"+timeToMs(0, 10)+"'>00:10</option>");
	$select.append("<option value='"+timeToMs(0, 15)+"'>00:15</option>");

	for(i = 0; i < 24; i++) {
		$.each(minArray, function(index, value) {
			if(i == 0 && value == "00") {
			} else {
				var timeStr = i;
				if(i < 10) {
					timeStr = "0"+i;
				}
				timeStr+=":"+value;

				$select.append("<option value='"+timeToMs(i, value)+"'>"+timeStr+"</option>");
			}
		});
	}

	$span = $("<span class='time-select-container'><i class='fa fa-times-circle'></i></span>");
	$span.prepend($select);
	$('body').append($span);
}