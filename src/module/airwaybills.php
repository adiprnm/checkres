<?php
    

    // A functio to add new airwaybills
    function addNewAWB($receiptNum, $slug) {

        $courier = getCourierBySlug($slug);
        
        $query = "SELECT * FROM receiptnums WHERE receipt_nums = '" . $receiptNum . "'";
        $result = mysqli_query($GLOBALS['conn'], $query);
        // debug($query);
        if (empty($result)) {
            $query = "INSERT INTO receiptnums (receipt_num, expedition_id) values ('" . $receiptNum . "', " . $courier['id'] .  ")";
            // debug($query);
            $result = mysqli_query($GLOBALS['conn'], $query);
            if (empty($result)) {
                debug("Error: " . mysqli_error($GLOBALS['conn']));
            }
        }
        
    }

    function getAWB($receiptNum) {
        $query = "SELECT * FROM receiptnums WHERE receipt_num = '" . $receiptNum . "'";
        $result = mysqli_query($GLOBALS['conn'], $query);
        
        if ( empty($result) ) {
            $query = "INSERT INTO receiptnums (receipt_num, expedition_id) values ('" . $receiptNum . "', " . $courier['id'] .  ")";
            debug("Test 1");
            $result = mysqli_query($GLOBALS['conn'], $query);
            
            if ( empty($result) ) {
                debug("Test 2");
                debug("Error: " . mysqli_error($GLOBALS['conn']));
            } else {
                return mysqli_fetch_assoc($result);
            }
        }

    }

?>