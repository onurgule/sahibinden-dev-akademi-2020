<?php
include "../../config/db.php";
$q = $db->prepare("SELECT *  FROM `ilanlar` WHERE adminID = :adminid ORDER BY date DESC LIMIT 0,10");
$q->execute(array("adminid" => $adminID));
$lastAdminListings = $q->fetchAll(PDO::FETCH_ASSOC);