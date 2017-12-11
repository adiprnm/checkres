<?php

    function addNewHistory($expeditionId, $date, $status, $location, $description) {
        $query = "INSERT INTO histories (expedition_id, date, 
            status_id, location, description) values
            (" . $expeditionId . ", '" . $date . "', " . $status['id']
            . ", '" . $location . "', '" . $description . "')";
        // debug($query);
        $result = mysqli_query($GLOBALS['conn'], $query);

        if ( !$result ) {
            debug("Error in histories.php: " . mysqli_error($GLOBALS['conn']));
        }
    }

    function deleteHistory($expeditionId) {
        $query = "DELETE FROM histories WHERE expedition_id = " . $expeditionId;
        $result = mysqli_query($GLOBALS['conn'], $query);

        // debug($query);
        if ( !$result ) {
            debug("Error in histories.php deleteHistory: " . mysqli_error($GLOBALS['conn']));
        }
    }

    function getHistory($AWBNums) {
        $query = "SELECT * FROM histories JOIN expedition_detail
            ON histories.expedition_id = expedition_detail.id
            WHERE expedition_detail.receipt_num = '" . $AWBNums . "'
            LIMIT 1";
        // debug($query);
        
        $result = mysqli_query($GLOBALS['conn'], $query);

        if ( !$result ) {
            debug("Error on hisories.php getHistory: " . mysqli_error($GLOBALS['conn']));
        } else {
            // debug(mysqli_fetch_assoc($result));
            return mysqli_fetch_assoc($result);
        }
    }
?>