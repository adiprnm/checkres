<?php 

    function addNewExpeditionDetail($receiptNum, $userId, $statusId, $dateSent) {
        $query = "INSERT INTO expedition_detail (receipt_num, user_id, status_id, date_sent)
            VALUES ('" . $receiptNum . "', " . $userId . ", " . $statusId . ", '" . $dateSent . "')";
        
        $result = mysqli_query($GLOBALS['conn'], $query);
        if ( !$result ) {
            debug("Error at expedition_detail.php addNewExpeditionDetail: " . mysqli_error($GLOBALS['conn']));
            return 1;          
        } else {
            return 0;
        }
    }

    function getExpeditionDetail($receiptNum) {
        $query = "SELECT * FROM expedition_detail WHERE receipt_num = '" . $receiptNum . "'";
        $result = mysqli_query($GLOBALS['conn'], $query);

        if ( !$result ) {
            debug("Error at expedition_detail.php getExpeditionDetail: " . mysql_error($GLOBALS['conn']));
        } else {
            return mysqli_fetch_assoc($result);
        }
    }

?>