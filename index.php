<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
    span.ui-state-default{
        border: 1px solid #c5c5c5 !important;
        background: #ff0000 !important;
        font-weight: normal !important;
        color: #ffffff !important;
        /* opacity: 1; */
    }
    .ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .ui-state-disabled {
        opacity: 1!important;
        filter: Alpha(Opacity=100)!important;
        background-image: none !important;
    }
  </style>
</head>
<body>
 
<p>Date: <input type="text" id="in">    <input type="text" id="out">  = <input type="text" id="TextBox3">  </p>
<?php
include'db.php';
$Pro_id = 4;
$dateslistselect1[]='';
$queryres = mysqli_query($conn, "SELECT start_date,end_date FROM ical_events WHERE event_pid='".$Pro_id."' AND YEAR(start_date) = YEAR(CURDATE()) OR YEAR(start_date) = YEAR(CURDATE()) + 1") or die(mysqli_error($conn));
while($row = mysqli_fetch_array($queryres))
{
$start = strtotime($row['start_date']);
$end = strtotime($row['end_date']);            
for ($i1=$start; $i1<=$end; $i1+=86400) { 
$dateslistselect1[]= '"'.date('d-m-Y',$i1).'"';   
}          
}
$dateslistselect1=array_filter($dateslistselect1);
$totaldayslist1 =implode(", ", $dateslistselect1);   
?>
<script>
var disableddates = [<?php echo $totaldayslist1; ?>];     
function DisableSpecificDates(date) {
var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
return [disableddates.indexOf(string) == -1];
}
</script>
<script type="text/javascript">
(function( $ ) {
var disableddates = [];     
$("#in").datepicker({
minDate: new Date(),
dateFormat: "mm-dd-yy",
beforeShowDay: DisableSpecificDates,
numberOfMonths: 1,
onSelect: function (selected) {
var dt = new Date(selected);
dt.setDate(dt.getDate() + 1);
$("#out").datepicker("option", "minDate", dt);
}
});
$("#out").datepicker({
minDate: new Date(),
dateFormat: "mm-dd-yy",
beforeShowDay: DisableSpecificDates,
numberOfMonths: 1,
onSelect: function (selected) {
var dt = new Date(selected);
dt.setDate(dt.getDate());
$("#out").datepicker("option", "maxDate", dt);
var start = $("#in").datepicker("getDate");
var end = $("#out").datepicker("getDate");
var days = (end - start) / (1000 * 60 * 60 * 24);
$("#TextBox3").val(days);
}
});
/* $( ".datepicker" ).datepicker( "option", "maxDate", dt );*/
})( jQuery );
</script>
</body>
</html>