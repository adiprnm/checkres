<?php
    

    // A functio to add new airwaybills
    function addNewAWB($receiptNum, $slug) {

        $courier = getCourierBySlug($slug);
        
        $query = "SELECT * FROM receiptnums WHERE receipt_nums = '" . $receiptNum . "'";
        $result = mysqli_query($GLOBALS['conn'], $query);
        // debug($query);
        if (!$result) {
            $query = "INSERT INTO receiptnums (receipt_num, expedition_id) values ('" . $receiptNum . "', " . $courier['id'] .  ")";
            // debug($query);
            $result = mysqli_query($GLOBALS['conn'], $query);
            if (!$result) {
                debug("Error: " . mysqli_error($GLOBALS['conn']));
            }
        }
        
    }

?>