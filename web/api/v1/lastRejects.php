<?php
include "../../config/db.php";
$q = $db->query("SELECT id,date,adminID FROM `ilanlar` WHERE status = 'REJECTED' ORDER BY date DESC LIMIT 0,10");
$lastRejects = $q->fetchAll(PDO::FETCH_ASSOC);