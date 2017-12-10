<?php
    
    include "conn.php";

    // A function to get courier by slug
    function getCourierBySlug($slug) {
        $query = "SELECT * FROM expedition_service where slug = '" . $slug . "'";
        $result = mysqli_query($GLOBALS['conn'], $query);

        return mysqli_fetch_assoc($result);
    }

    // A function to get courier by id
    function getCourierById($id) {
        $query = "SELECT * FROM expeditioin_service where id = " . $id;
        $result = mysql_query($GLOBALS['conn'], $query);

        return mysqli_fetch_assoc($result);;
    }

?>