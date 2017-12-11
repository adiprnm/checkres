<?php 

    function getStatusByDesc($statusDesc) {
        $query = "SELECT * FROM status WHERE status_desc = '" . $statusDesc . "'";
        $result = mysqli_query($GLOBALS['conn'], $query);
        // debug($result);
        if ( !$result ) {
            debug("Hi");
        } else {
            return mysqli_fetch_assoc($result);
        }
        
    }

?>