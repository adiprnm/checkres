<?php 

    function addNewExpeditionDetail($receiptNum, $userId, $statusId, $dateSent) {
        $query = "INSERT INTO expedition_detail (receipt_num, user_id, status_id, date_sent)
            VALUES ('" . $receiptNum . "', " . $userId . ", " . $statusId . ", '" . $dateSent . "')";
        
        $result = mysqli_query($GLOBALS['conn'], $query);
        if ( !$result ) {
            debug("Error: " . mysqli_error($GLOBALS['conn']));
            return 1;          
        } else {
            return 0;
        }
    }

?>