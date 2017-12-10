<?php

    include "src/conn.php";

    $expeditionServices = mysqli_query($GLOBALS['conn'], "SELECT slug, name FROM expedition_service");
    $options = '<div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div><div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet"><input type="text" class="form-control" id="usr" name="no_resi[]" placeholder="Masukan Resi"></div><div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet"><div class="form-group"><select class="form-control" name="couriers[]">';
    $result = '';

    
    while ($row = mysqli_fetch_assoc($expeditionServices)) {
        // echo "<pre>";
        // print_r($rows['slug']);
        // echo "</pre>";
        $options .= '<option value="' . $row['slug'] .'">' . $row['name'] . '</option>';
        $result .= '<option value="' . $row['slug'] .'">' . $row['name'] . '</option>';
    }
    
    $options .= "</select></div></div>";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkres</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $("#btnAdd").click(function() { 
            $("#formfix").append('<?php echo $options ?>');
        });
        $('body').on('click','#btnRemove',function() {
            $(this).parent('div.mdl-cell').remove()
        });
    });
</script>
<style>
    #ex3 { width: 250px; }
    #judul{
        margin-top: 15px;
    }
    #formfix{
        margin-top: 10px;
    }
    .spacer{
        margin-top: -30px;
    }
    #myButton {
            width: 100%;
            height: 40px;
            min-width: initial;
        }
    @media (max-width: 840px) {
        .space { display: none; }
        .add{
            margin-top: -40px;
        }
        .send{
            margin-top: -50px;
        }
           /* hide it elsewhere */
    }

    @media (min-width: 1145px) and (max-width: 1282px){
        .add{
            margin-top: -95px;
            margin-left: -30px;
        }
        .fixedin{
        margin-top: -14px;
        }
        .send{
            margin-top: -50px;
        }
    }
    @media (min-width: 1026px) and (max-width: 1145px){
        .add{
            margin-top: -95px;
            margin-left: -20px;
        }
        .send{
            margin-top: -50px;
        }
    }
    @media (min-width: 907px) and (max-width: 1026px){
        .add{
            margin-top: -95px;
            margin-left: -10px;
        }
        .send{
            margin-top: -50px;
        }
    }
    @media (min-width: 841px) and (max-width: 907px){
        .add{
            margin-top: -95px;
            margin-left: -3px;
        }
        .send{
            margin-top: -50px;
        }
    }
    </style>
</head>

<body>
    <!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title">CheckRes</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <span class="mdl-layout-title">CheckRes</span>
    <nav class="mdl-navigation">
      <a class="mdl-navigation__link" href="">Link</a>
      <a class="mdl-navigation__link" href="">Link</a>
      <a class="mdl-navigation__link" href="">Link</a>
      <a class="mdl-navigation__link" href="">Link</a>
    </nav>
  </div>
  <main class="mdl-layout__content">
    <div class="page-content">
        <!-- <div class="mdl-grid" id="judul">
            <div class="mdl-cell mdl-cell--6-col" style="margin-left: 150px"><center><span><h4>RESI</h4></span></center></div>
            <div class="mdl-cell mdl-cell--6-col" style="margin-left: -30px"><center><span><h4>WAHANA</h4></span></center></div>
        </div> -->
        <form action="result.php" method="GET" id="myForm">
        <div class="mdl-grid" id="formfix">
            <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet"><center><h1>C# "CheckRes"</h1></center></div>
            <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet spacer"><center><h2>Check Resi Semua Ekspedisi</h2></center></div>
            <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet space">&nbsp;</div>
            <div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div>
            <div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet">
                <input type="text" class="form-control" id="usr" name="no_resi[]" placeholder="Masukan Resi">
            </div>
            <div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet">
                <div class="form-group">
                    <select class="form-control" name="couriers[]">
                    <?php
                        
                        var_dump($result);
                        
                        while ($row = mysqli_fetch_assoc($expeditionServices)) {
                            
                            foreach ($row as $key => $value) {
                            }
                        }

                    ?>
                    </select>
                </div>
            </div>
            <div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div>
        </div>
        </form> 
        <div class="mdl-grid" id="formfix">
            <div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div>
            <div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div>
            <div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div>
            <div class="mdl-cell mdl-cell--3-col mdl-cell--6-col-tablet space"></div>
            <div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet mdl-cell--12-col-phone add"> <p align="right"><button class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored" id="btnAdd" value="Add"><i class="material-icons">add</i></button></p></div>
            <div class="mdl-cell mdl-cell--1-col mdl-cell--12-col-tablet sapce"></div>
        </div>
        <div class="mdl-grid" id="formfix">
            <div class="mdl-cell mdl-cell--2-col mdl-cell--6-col-tablet space"></div>
            <div class="mdl-cell mdl-cell--4-col mdl-cell--6-col-tablet space"></div>
            <div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet send"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="myButton" onclick="document.getElementById('myForm').submit()"><span>Check Resi</span></button></div>
            <div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div>
        </div>
    </div>
  </main>
</div>
</body>
</html>