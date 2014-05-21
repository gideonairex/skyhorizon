<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>	<tr>		<td class="dvInnerHeader">			<b>{$REPORTNAME}</b>		</td>	</tr>	<tr>		<td class="dvtCellInfo" >        <script src="include/amcharts/amcharts/amcharts.js" type="text/javascript"></script>            <script type="text/javascript">            			var chart;            var chartData = [{ldelim}                country: "Czech Republic",                litres: 156.90            {rdelim}, {ldelim}                country: "Ireland",                litres: 131.10            {rdelim}, {ldelim}                country: "Germany",                litres: 115.80            {rdelim}, {ldelim}                country: "Australia",                litres: 109.90            {rdelim}, {ldelim}                country: "Austria",                litres: 108.30            {rdelim}, {ldelim}                country: "UK",                litres: 99.00            {rdelim}];            AmCharts.ready(function () {ldelim}                // RADAR CHART                chart = new AmCharts.AmRadarChart();                chart.dataProvider = chartData;                chart.categoryField = "country";                chart.startDuration = 2;                // VALUE AXIS                var valueAxis = new AmCharts.ValueAxis();                valueAxis.axisAlpha = 0.15;                valueAxis.minimum = 0;                valueAxis.dashLength = 3;                valueAxis.axisTitleOffset = 20;                valueAxis.gridCount = 5;                chart.addValueAxis(valueAxis);                // GRAPH                var graph = new AmCharts.AmGraph();                graph.valueField = "litres";                graph.bullet = "round";                graph.balloonText = "[[value]] litres of beer per year"                chart.addGraph(graph);                // WRITE                chart.write("chartdiv");            {rdelim});        </script>        <div id="chartdiv" style="width:100%; height:400px;"></div>		</td>	</tr>		<tr>		<td class="dvtCellLabel">			<b>MAP View</b>		</td>	</tr>		<tr>		<td class="dvtCellLabel">			<style>				#map-canvas{ldelim}				  height: 500px;				{rdelim}			</style>						<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>			<script>			  var map;			  var infoWindow;			  function initializeMAP() {ldelim}				console.log(google.maps.MapTypeId)				var myLatLng = new google.maps.LatLng(14.617222346451792,121.12362384796143);				var mapOptions = {ldelim}				  zoom: 15,				  center: myLatLng,				  mapTypeId: google.maps.MapTypeId.ROADMAP,								{rdelim};				 map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);								var kingsville = [								new google.maps.LatLng(14.623285105306913,121.11697196960449),								new google.maps.LatLng(14.622454600287766,121.11714363098145),								new google.maps.LatLng(14.622246973542223,121.11628532409668),								new google.maps.LatLng(14.619381704409227,121.11680030822754),								new google.maps.LatLng(14.619257126642507,121.1184310913086),								new google.maps.LatLng(14.618177449704746,121.11847400665283),								new google.maps.LatLng(14.617180820129217,121.11851692199707),								new google.maps.LatLng(14.61593502680186,121.11984729766846),								new google.maps.LatLng(14.61157469453187,121.12109184265137),								new google.maps.LatLng(14.60999664819944,121.12143516540527),								new google.maps.LatLng(14.609830537400116,121.12435340881348),								new google.maps.LatLng(14.607588029323326,121.1259412765503),								new google.maps.LatLng(14.607421916703924,121.13023281097412),								new google.maps.LatLng(14.607920254185593,121.13272190093994),								new google.maps.LatLng(14.610951782859377,121.1335802078247),								new google.maps.LatLng(14.614606172800096,121.13126277923584),								new google.maps.LatLng(14.616557924348557,121.13126277923584),								new google.maps.LatLng(14.617928292734748,121.13053321838379),								new google.maps.LatLng(14.623575781321572,121.12473964691162),								new google.maps.LatLng(14.62498763077663,121.12431049346924),								new google.maps.LatLng(14.623326630475404,121.11594200134277)];				 kingsvilleTerrain = new google.maps.Polygon({ldelim}				  paths: kingsville,				  strokeColor: '#FF0000',				  strokeOpacity: 0.8,				  strokeWeight: 3,				  fillColor: '#FF0000',				  fillOpacity: 0.35				{rdelim});				kingsvilleTerrain.setMap(map);							  {rdelim}	  			</script>				<div id="map-canvas"></div>		</td>	</tr></table>