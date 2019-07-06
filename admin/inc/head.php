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
  <link href="css/style.css" rel="stylesheet">
  <link href="css/jquery-ui.1.11.2.min.css" rel="stylesheet" />
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!--   <script src="js/tinymce/tinymce.min.js"></script>
<script>
  tinymce.init({
  selector: "#mytextarea",
  theme: "modern",
  
  plugins: [
       "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
       "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
       "save table contextmenu directionality emoticons template paste textcolor"
 ],
 content_css: "css/content.css",
 toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons fullscreen | autosave ", 
 style_formats: [
      {title: 'Bold text', inline: 'b'},
      {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
      {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
      {title: 'Example 1', inline: 'span', classes: 'example1'},
      {title: 'Example 2', inline: 'span', classes: 'example2'},
      {title: 'Table styles'},
      {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
  ]
 }); 
</script> -->


<!-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="js/tinymce/tinymce.min.js"></script>
 <script>
 tinymce.init({
   selector: 'textarea#mytextarea',
   height: '400',
   plugins: [
   'advlist autolink lists link image charmap print preview hr anchor pagebreak',
     'searchreplace wordcount visualblocks visualchars code fullscreen',
     'insertdatetime media nonbreaking save table contextmenu directionality',
     'emoticons template paste textcolor colorpicker textpattern imagetools'
   ],
   toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
   toolbar2: 'print preview media | forecolor backcolor emoticons',
   image_advtab: true,
 });
 </script> -->


</head>