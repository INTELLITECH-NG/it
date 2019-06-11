<?php 
include '../inc/database.php';
include 'inc/fun.php'; 

Check_Admin ();

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="css/jquery-ui.1.11.2.min.css" rel="stylesheet" />

  <script>
window.onload = function () {

// Construct options first and then pass it as a parameter
var options1 = {
  animationEnabled: true,
  /*title: {
    text: "Chart inside a jQuery Resizable Element"
  },*/
  data: [{
    type: "column", //change it to line, area, bar, pie, etc
    legendText: "Try Resizing with the handle to the bottom right",
    showInLegend: true,
    dataPoints: [
      { y: 10 },
      { y: 6 },
      { y: 14 },
      { y: 12 },
      { y: 19 },
      { y: 14 },
      { y: 26 },
      { y: 10 },
      { y: 22 }
      ]
    }]
};

$("#resizable").resizable({
  create: function (event, ui) {
    //Create chart.
    $("#chartContainer1").CanvasJSChart(options1);
  },
  resize: function (event, ui) {
    //Update chart size according to its container size.
    $("#chartContainer1").CanvasJSChart().render();
  }
});

}
</script>

</head>