$(document).ready(function() {
  $( "#datepicker" ).datepicker('setDate', new Date());
  $( "#monthpicker" ).MonthPicker({ Button: false, SelectedMonth: new Date().getMonth() + '/' + new Date().getFullYear()});
  $( "#select" ).selectmenu();
});

var resetCanvas = function(){
  $('#canvas').remove(); // 
  $('#canvasframe').append('<canvas id="canvas"></canvas>');
  var canvas = document.getElementsByTagName('canvas')[0];
  canvas.width  = $('#canvasframe').width(); 
  canvas.height = $('#canvasframe').height();
  canvas.style.width  = $('#canvasframe').width() + 'px';
  canvas.style.height = $('#canvasframe').height() + 'px';
  
  $('#infosframe').html("");  
};


function daysInMonth(month,year) {
    month += 1;
    if(month == 12){month = 0;}
    return new Date(year, month, 0).getDate();
}

// Get data from html and parse them into json
var tracebackdata = Papa.parse($.trim($( "div.traceback_data" ).text()),{	delimiter: ";",	newline: "\n"}).data;
var connectiondata = Papa.parse($.trim($( "div.connection_data" ).text()),{	delimiter: ";",	newline: "\n"}).data;
var datedata = Papa.parse($.trim($( "div.date_data" ).text()),{	delimiter: ";",	newline: "\n"}).data;
var admindata = Papa.parse($.trim($( "div.admin_data" ).text()),{	delimiter: ";",	newline: "\n"}).data;

// Parse datetime variables
$.each(tracebackdata, function( index, value ) {
  tracebackdata[index][1] = getDateFromFormat(value[1],'yyyyMMddHHmmss');
  tracebackdata[index][2] = getDateFromFormat(value[2],'yyyyMMddHHmmss');
  tracebackdata[index][4] = parseFloat(value[4]);
});

$.each(datedata, function( index, value ) {
  datedata[index][0] = getDateFromFormat(value[0],'yyyyMMddHHmmss');
});

$.each(connectiondata, function( index, value ) {
  connectiondata[index][0] = getDateFromFormat(value[0],'yyyyMMddHHmmss');
});

$.each(admindata, function( index, value ) {
  admindata[index][2] = parseFloat(value[2]);
});



var chartDayCoffee = function(theday){
  // build data
      var labels = [];
      for (var i = 0; i < 24; i++) {
         labels.push(i);
      } 
      var data = [];
      for (var i = 0; i < 24; i++) {
         data.push(0);
      } 
      var number = 0;
      $.each(datedata, function( index, value ) {
        var thatday = new Date(value[0]);
        if(theday.getDate() == thatday.getDate() && theday.getMonth() == thatday.getMonth() && theday.getFullYear() == thatday.getFullYear())
        {
          data[thatday.getHours()] += 1;
          number+=1;
        } 
      });

      var barChartData = {
	      labels : labels,
	      datasets : [
		      {
			      fillColor : "rgba(220,220,220,0.5)",
			      strokeColor : "rgba(220,220,220,0.8)",
			      highlightFill: "rgba(220,220,220,0.75)",
			      highlightStroke: "rgba(220,220,220,1)",
			      data : data
		      }
	      ]

      }
      resetCanvas();
      $('#infosframe').append('<p>Number of coffees: ' + number.toString() + '</p>'); 
      $('#infosframe').append('<p>Mean per hour: ' + (number/24).toFixed(2).toString() + '</p>'); 
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
};

var chartDayUpdate = function(theday){
  // build data
      var labels = [];
      for (var i = 0; i < 24; i++) {
         labels.push(i);
      } 
      var data = [];
      for (var i = 0; i < 24; i++) {
         data.push(0);
      } 
      var number = 0;
      var previous = new Date(0);
      $.each(tracebackdata, function( index, value ) {
        var thatday = new Date(value[1]);
        if(thatday.getTime() != previous.getTime() && theday.getDate() == thatday.getDate() && theday.getMonth() == thatday.getMonth() && theday.getFullYear() == thatday.getFullYear())
        {
          data[thatday.getHours()] += 1;
          previous.setTime(thatday.getTime());
          number+=1;
        } 
      });

      var barChartData = {
	      labels : labels,
	      datasets : [
		      {
			      fillColor : "rgba(220,220,220,0.5)",
			      strokeColor : "rgba(220,220,220,0.8)",
			      highlightFill: "rgba(220,220,220,0.75)",
			      highlightStroke: "rgba(220,220,220,1)",
			      data : data
		      }
	      ]

      }
      resetCanvas();
      $('#infosframe').append('<p>Number of updates: ' + number.toString() + '</p>'); 
      $('#infosframe').append('<p>Mean per hour: ' + (number/24).toFixed(2).toString() + '</p>'); 
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
};

var chartDayConnection = function(theday){
  // build data
      var labels = [];
      for (var i = 0; i < 24; i++) {
         labels.push(i);
      } 
      var data = [];
      for (var i = 0; i < 24; i++) {
         data.push(0);
      } 
      var number = 0;
      var previous = new Date(0);
      $.each(connectiondata, function( index, value ) {
        var thatday = new Date(value[0]);
        if(thatday.getTime() != previous.getTime() && theday.getDate() == thatday.getDate() && theday.getMonth() == thatday.getMonth() && theday.getFullYear() == thatday.getFullYear())
        {
          data[thatday.getHours()] += 1;
          previous.setTime(thatday.getTime());
          number+=1;
        } 
      });

      var barChartData = {
	      labels : labels,
	      datasets : [
		      {
			      fillColor : "rgba(220,220,220,0.5)",
			      strokeColor : "rgba(220,220,220,0.8)",
			      highlightFill: "rgba(220,220,220,0.75)",
			      highlightStroke: "rgba(220,220,220,1)",
			      data : data
		      }
	      ]

      }
      resetCanvas();
      $('#infosframe').append('<p>Number of connections: ' + number.toString() + '</p>'); 
      $('#infosframe').append('<p>Mean per hour: ' + (number/24).toFixed(2).toString() + '</p>'); 
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
};


var chartMonthCoffee = function(themonth){
  // build data
      var N = daysInMonth(themonth.getMonth(),themonth.getFullYear());
      var labels = [];
      for (var i = 0; i < N; i++) {
         labels.push(i+1);
      } 
      var data = [];
      for (var i = 0; i < N; i++) {
         data.push(0);
      } 
      var number = 0;
      $.each(datedata, function( index, value ) {
        var thatmonth = new Date(value[0]);
        if(themonth.getMonth() == thatmonth.getMonth() && themonth.getFullYear() == thatmonth.getFullYear())
        {
          data[thatmonth.getDate()-1] += 1;
          number +=1;
        } 
      });

      var barChartData = {
	      labels : labels,
	      datasets : [
		      {
			      fillColor : "rgba(220,220,220,0.5)",
			      strokeColor : "rgba(220,220,220,0.8)",
			      highlightFill: "rgba(220,220,220,0.75)",
			      highlightStroke: "rgba(220,220,220,1)",
			      data : data
		      }
	      ]

      }
      resetCanvas();
      $('#infosframe').append('<p>Number of coffees: ' + number.toString() + '</p>'); 
      $('#infosframe').append('<p>Mean per day: ' + (number/N).toFixed(2).toString() + '</p>'); 
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
};

var chartMonthUpdate = function(themonth){
  // build data
      var N = daysInMonth(themonth.getMonth(),themonth.getFullYear());
      var labels = [];
      for (var i = 0; i < N; i++) {
         labels.push(i+1);
      } 
      var data = [];
      for (var i = 0; i < N; i++) {
         data.push(0);
      } 
      
      var previous = new Date(0);
      var number = 0;
      $.each(tracebackdata, function( index, value ) {
        var thatmonth = new Date(value[1]);
        if(thatmonth.getTime() != previous.getTime() && themonth.getMonth() == thatmonth.getMonth() && themonth.getFullYear() == thatmonth.getFullYear())
        {
          data[thatmonth.getDate()-1] += 1;
          previous.setTime(thatmonth.getTime());
          number +=1;
        } 
      });
      
      var barChartData = {
	      labels : labels,
	      datasets : [
		      {
			      fillColor : "rgba(220,220,220,0.5)",
			      strokeColor : "rgba(220,220,220,0.8)",
			      highlightFill: "rgba(220,220,220,0.75)",
			      highlightStroke: "rgba(220,220,220,1)",
			      data : data
		      }
	      ]

      }
      resetCanvas();
      $('#infosframe').append('<p>Number of updates: ' + number.toString() + '</p>'); 
      $('#infosframe').append('<p>Mean per day: ' + (number/N).toFixed(2).toString() + '</p>'); 
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
};

var chartMonthConnection = function(themonth){
  // build data
      var N = daysInMonth(themonth.getMonth(),themonth.getFullYear());
      var labels = [];
      for (var i = 0; i < N; i++) {
         labels.push(i+1);
      } 
      var data = [];
      for (var i = 0; i < N; i++) {
         data.push(0);
      } 
      
      var previous = new Date(0);
      var number = 0;
      $.each(connectiondata, function( index, value ) {
        var thatmonth = new Date(value[0]);
        if(thatmonth.getTime() != previous.getTime() && themonth.getMonth() == thatmonth.getMonth() && themonth.getFullYear() == thatmonth.getFullYear())
        {
          data[thatmonth.getDate()-1] += 1;
          previous.setTime(thatmonth.getTime());
          number +=1;
        } 
      });
      
      var barChartData = {
	      labels : labels,
	      datasets : [
		      {
			      fillColor : "rgba(220,220,220,0.5)",
			      strokeColor : "rgba(220,220,220,0.8)",
			      highlightFill: "rgba(220,220,220,0.75)",
			      highlightStroke: "rgba(220,220,220,1)",
			      data : data
		      }
	      ]

      }
      resetCanvas();
      $('#infosframe').append('<p>Number of connections: ' + number.toString() + '</p>'); 
      $('#infosframe').append('<p>Mean per day: ' + (number/N).toFixed(2).toString() + '</p>'); 
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
};

var chartMoney = function(){
  // build data
      var N = admindata.length;
      var labels = [];
      for (var i = 0; i < N; i++) {
         labels.push(admindata[i][0]);
      } 
      var floatMoney = 0;
      var neg = 0;
      var pos = 0;
      var negS = 0;
      var posS = 0;
      var data = [];
      for (var i = 0; i < N; i++) {
         data.push(admindata[i][2]);
         floatMoney += admindata[i][2];
         if(admindata[i][2] >= 0)
         {
          pos+=1;
          posS+=admindata[i][2];
         }else{
          neg+=1;
          negS+=admindata[i][2];
         }
      } 
      
      var barChartData = {
	      labels : labels,
	      datasets : [
		      {
			      fillColor : "rgba(220,220,220,0.5)",
			      strokeColor : "rgba(220,220,220,0.8)",
			      highlightFill: "rgba(220,220,220,0.75)",
			      highlightStroke: "rgba(220,220,220,1)",
			      data : data
		      }
	      ]

      }
      resetCanvas();
      $('#infosframe').append('<p>Current money balance: ' + floatMoney.toFixed(2).toString() + '</p>'); 
      $('#infosframe').append('<p>Number of positive people: ' + pos.toString() +  '  money: ' + posS.toFixed(2).toString() + '</p>'); 
      $('#infosframe').append('<p>Number of negative people: ' + neg.toString() +  '  money: ' + negS.toFixed(2).toString() + '</p>'); 
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
};


$("#datepicker").datepicker({
   onSelect: function(dateText, inst) { 
      var theday = $(this).datepicker('getDate'); //the getDate method
      if($("#select").val() == "coffee")
      {
        chartDayCoffee(theday);
      }else if($("#select").val() == "updates"){
        chartDayUpdate(theday);
      }
   }
});

$("#monthpicker").MonthPicker({
   OnAfterChooseMonth: function(selectedDate) {
      //selectedDate.setTime( selectedDate.getTime() - (selectedDate.getTimezoneOffset()*60*1000) );
      if($("#select").val() == "coffee")
      {
        chartMonthCoffee(selectedDate);
      }else if($("#select").val() == "updates"){
        chartMonthUpdate(selectedDate);
      }else if($("#select").val() == "connections"){
        chartMonthConnection(selectedDate);
      }
    }
});

$("#select").selectmenu({
        select: function () {
          //theday.setTime( theday.getTime() - (theday.getTimezoneOffset()*60*1000) );
          if(this.value == "coffee")
          {
            var theday = $("#datepicker").datepicker('getDate'); //the getDate method
            chartDayCoffee(theday);
          }else if(this.value == "updates")
          {
            var theday = $("#datepicker").datepicker('getDate');
            chartDayUpdate(theday);
          }else if(this.value == "connections")
          {
            var theday = $("#datepicker").datepicker('getDate');
            chartDayConnection(theday);
          }else if(this.value == "money")
          {
            chartMoney();
          }
        }
    });


window.onload = function(){
  resetCanvas();
	var theday = new Date(); //the getDate method
  chartDayCoffee(theday);
}

