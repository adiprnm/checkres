<?php
    include "src/couriers.php";
    include "src/aftership.php";
    
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
            
            } else {
                $postData = callAfterShipAPI('POST', $_GET['no_resi'][$k], $slug);
                $getData = callAfterShipAPI('GET', $_GET['no_resi'][$k], $slug);
                $info[$k] = $getData['info'];
                $temp = json_decode($getData['response']);

                
                if (count($temp->data->tracking->checkpoints) > 0) {
                    $results[$k] = json_decode($data['response']);
                    $tracking[$k] = $results[$k]->data->tracking;
                    $checkpoints[$k] = $results[$k]->data->tracking->checkpoints;
                } else {
                    $results[$k] = "";
                    $tracking[$k] = "";
                    $checkpoints[$k] = [];
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#btnAdd").click(function() {
            $("#formfix").append('<div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div><div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet fixedin"><input type="text" class="form-control" id="usr" placeholder="Masukan Resi"></div><div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet fixedin"><div class="form-group"><select class="form-control"><option>JNE</option><option>SICEPAT</option><option>NINJA</option><option>POS</option></select></div></div>' + '<div class="mdl-cell mdl-cell--2-col mdl-cell--12-col-tablet space"></div>');
        });
        $('body').on('click','#btnRemove',function() {
            $(this).parent('div.mdl-cell').remove()
        });
    });
</script>
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
        <?php foreach ($results as $k => $result): ?>
        <?php if (count($checkpoints[$k]) > 0): ?>
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
                <center>
                <div class="demo-card-wide mdl-card mdl-shadow--2dp">
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
                                    <td id="kiri"><b>Asal</b></td>
                                    <td id="kiri">Terkirim</td>
                                </tr>
                                <tr>
                                    <td id="kiri"><b>Tujuan</b></td>
                                    <td id="kiri">Terkirim</td>
                                </tr>
                                <tr>
                                    <td id="kiri"><b>Tanggal Diterima</b></td>
                                    <td id="kiri">Terkirim</td>
                                </tr>
                                <tr>
                                      <td id="kiri"><b>Nama Penerima</b></td>
                                      <td id="kiri">Terkirim</td>
                                </tr>
                                <tr>
                                      <td id="kiri"><b>Nomor Telephone</b></td>
                                      <td id="kiri">Terkirim</td>
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
                <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
                  <div class="mdl-card__actions mdl-card--border">
                    <div style="display: inline-block; text-align: right; width: 100%">
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="window.location.href='hasil.html'">
                        <i class="material-icons">keyboard_arrow_left</i>
                    </button>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="window.location.href='hasil.html'">
                        <i class="material-icons">keyboard_arrow_right</i>
                    </button>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="window.location.href='Checkres.html'">
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
        </div>
        <?php else: ?>
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="margin-top: 10%">
                <center>
                <div class="demo-card-wide mdl-card mdl-shadow--2dp">
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
                <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
                  <div class="mdl-card__actions mdl-card--border">
                    <div style="display: inline-block; text-align: right; width: 100%">
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="window.location.href='hasil.html'">
                        <i class="material-icons">keyboard_arrow_left</i>
                    </button>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="window.location.href='hasil.html'">
                        <i class="material-icons">keyboard_arrow_right</i>
                    </button>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="window.location.href='Checkres.html'">
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
        </div>
        <?php endif;?>
        <?php endforeach; ?>
    </div>
  </main>
</div>
</body>
</html>