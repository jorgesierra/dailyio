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