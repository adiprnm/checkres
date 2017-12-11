<?php

    include "src/conn.php";
    include "src/module/status.php";
    include "src/module/couriers.php";
    include "src/module/aftership.php";
    include "src/module/airwaybills.php";
    include "src/module/expedition_detail.php";
    include "src/module/histories.php";
    

    if(empty($_GET)) {
        echo "Error";
    } else {
        $results = array();
        $tracking = array();
        $checkpoints = array();
        $info = array();
        $couriers = array();
        
        foreach ($_GET['couriers'] as $k => $slug) {
            
            $couriers[$k] = getCourierBySlug($slug);
            
            $data = callAfterShipAPI('GET', $_GET['no_resi'][$k], $slug);
            $info[$k] = $data['info'];
            $temp = json_decode($data['response']);
            

            if ($data['error']) {
                die("eror");
            } else if ($info[$k]['http_code'] == 200) {        
                $results[$k] = json_decode($data['response']);
                $tracking[$k] = $results[$k]->data->tracking;
                $checkpoints[$k] = $results[$k]->data->tracking->checkpoints;

                // delete previous history
                $history = getHistory($tracking[$k]->tracking_number);
                // debug($history);
                deleteHistory($history['expedition_id']);
                
                // GET NEW EXPEDITION DETAIL
                $expeditionDetail = getExpeditionDetail($tracking[$k]->tracking_number);
                // INSERT TO histories table
                foreach ($checkpoints[$k] as $checkpoint) {
                    $status = getStatusByDesc($checkpoint->tag);
                    
                    addNewHistory($expeditionDetail['id'],
                        $checkpoint->checkpoint_time,
                        $status,
                        $checkpoint->location,
                        $checkpoint->message);
                }
                

            
            } else {
                // if no_resi empty
                if (empty($_GET['no_resi'][$k])) {
                    $results[$k] = "";
                    $tracking[$k] = "";
                    $checkpoints[$k] = [];
                } else {
                    $postData = callAfterShipAPI('POST', $_GET['no_resi'][$k], $slug);
                    sleep(5);
                    $getData = callAfterShipAPI('GET', $_GET['no_resi'][$k], $slug);
                    $info[$k] = $getData['info'];
                    $temp = json_decode($getData['response']);
                    debug($temp);
                    
                    if (!emptycount($temp->data->tracking->checkpoints) > 0) {
                        $results[$k] = json_decode($getData['response']);
                        
                        $tracking[$k] = $results[$k]->data->tracking;
                        $checkpoints[$k] = $results[$k]->data->tracking->checkpoints;
    
                        // debug($tracking[$k]->tracking_number);
                        // insert new AWB to database
                        addNewAWB($tracking[$k]->tracking_number, $slug);
                        
                        $status = getStatusByDesc($tracking[$k]->tag);
                        $userId = 1;
                        $dateSent = $tracking[$k]->shipment_pickup_date;
    
                        // INSERT NEW EXPEITION DETAIL
                        addNewExpeditionDetail($tracking[$k]->tracking_number,
                            $userId,
                            $status['id'],
                            $dateSent);
    
                        // GET NEW EXPEDITION DETAIL
                        $expeditionDetail = getExpeditionDetail($tracking[$k]->tracking_number);
                        // INSERT TO histories table
                        foreach ($checkpoints[$k] as $checkpoint) {
                            $status = getStatusByDesc($checkpoint->tag);
                            
                            addNewHistory($expeditionDetail['id'],
                                $checkpoint->checkpoint_time,
                                $status,
                                $checkpoint->location,
                                $checkpoint->message);
                        }
                    } else {
                        $results[$k] = "";
                        $tracking[$k] = "";
                        $checkpoints[$k] = [];
                    }   
                }
            }

        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkres</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<style>
table{
    width: 100%;
}
 td {

    /* css-3 */
    white-space: -o-pre-wrap; 
    word-wrap: break-word;
    white-space: pre-wrap; 
    white-space: -moz-pre-wrap; 
    white-space: -pre-wrap;

}   #ex3 { width: 250px; }
    #judul{
        margin-top: 15px;
    }
    #formfix{
        margin-top: 10px;
    }
    .spacer{
        margin-top: -30px;
    }
    #kiri{
        text-align: left;
    }
    #myButton {
            width: 100%;
            height: 40px;
            min-width: initial;
        }
    .demo-card-wide.mdl-card {
      width: 80%;
    }
    .demo-card-wide > .mdl-card__title {
      color: #fff;
      height: 100px;
      align-items: center;
      text-align: center;
 
    }
    .demo-card-wide > .mdl-card__menu {
      color: #fff;
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
        <?php //foreach ($results as $k => $result): ?>
        <?php //if (count($checkpoints[$k]) > 0): ?>
        <div class="mdl-grid">
            <?php foreach ($results as $k => $result): ?>
            
            <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">          
                <center>
                <?php if (count($checkpoints[$k]) > 0): ?>
                    <div id="result<?= $k ?>" style="display: none" class="demo-card-wide mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title">
                            <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
                                <Center>
                                    <h2 style="color: black; margin-top: 10px;"><?= $couriers[$k]['name'] ?></h2><br><hr style="width: 50%; margin-top: -20px;">
                                    <h4 style="color: black; margin-top: -10px;"><?= $couriers[$k]['customer_services'] ?></h4>
                                </Center>
                            </div>
                        </div>
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet">
                                <table class="mdl-data-table mdl-js-data-table">
                                    <thead>
                                        <tr>
                                            <th colspan="2"><center>Informasi</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="kiri"><b>No Resi</b></td>
                                            <td id="kiri"><?= $tracking[$k]->tracking_number ?></td>
                                        </tr>
                                        <tr>
                                            <td id="kiri"><b>Status</b></td>
                                            <td id="kiri"><?= $tracking[$k]->tag ?></td>
                                        </tr>
                                        <tr>
                                            <td id="kiri"><b>Tanggal Pengiriman</b></td>
                                            <td id="kiri"><?= $tracking[$k]->shipment_pickup_date ?></td>
                                        </tr>
                                        <?php if ($tracking[$k]->tag == 'Delivered'): ?>
                                        <tr>
                                            <td id="kiri"><b>Tanggal Diterima</b></td>
                                            <td id="kiri"><?= $checkpoints[$k][count($checkpoints[$k])-1]->checkpoint_time; ?></td>
                                        </tr>
                                        <?php endif ?>
                                </tbody>
                                </table>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet">
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="3"><center>History</center></th>
                                            </tr>
                                            <tr>
                                                <td><center><b>Tanggal</b></center></td>
                                                <td><center><b>Status</b></center></td>
                                                <td><center><b>Lokasi</b></center></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($checkpoints[$k] as $checkpoint): ?>
                                            <tr>
                                                <td id="kiri"><?= $checkpoint->checkpoint_time; ?></td>
                                                <td id="kiri"><?= $checkpoint->message; ?></td>
                                                <td id="kiri"><?= $checkpoint->location; ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </center>
                            </div>
                        </div>
                    
                <?php else: ?>
                    <div id="result<?= $k ?>" style="display: none" class="demo-card-wide mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title">
                        </div>
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
                                <center>
                                    <h2>
                                        Mohon Maaf ! <br>
                                        Resi Yang Anda Cari <br>
                                        Tidak Ditemukan <br>
                                        <hr>
                                    </h2>
                                </center>
                            </div>
                        </div>

                <?php endif; ?>

                        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
                            <div class="mdl-card__actions mdl-card--border">
                                <div style="display: inline-block; text-align: right; width: 100%">
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="prev(<?= $k ?>)">
                                        <i class="material-icons">keyboard_arrow_left</i>
                                    </button>
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="next(<?= $k ?>)">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                    </button>
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="window.location.href='index.php'">
                                        <i class="material-icons">home</i>
                                    </button>
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style="text-transform: none;">
                                        <a style="color: white; font-size: 9px;">Kunjungi Ekspedisi</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </center>
            </div>
            
            <?php endforeach; ?>
        </div>
       
    </div>
  </main>
</div>
<script>
    document.getElementById("result0").style.display = 'block';
    
    function next(id) {
        var nextId = id + 1;
        var numElement = <?= count($results) ?>
        
        if (nextId == numElement) {
            nextId = 0;
        }

        document.getElementById("result" + id).style.display = 'none';
        document.getElementById("result" + nextId).style.display = 'block';   
    }

    function prev(id) {
        var prevId = id - 1;
        var numElement = <?= count($results) ?>

        if (prevId < 0) {
            prevId = numElement - 1;
        }

        document.getElementById("result" + id).style.display = 'none';
        document.getElementById("result" + prevId).style.display = 'block';
    }
</script>
</body>
</html>