<?php
include "../../config/db.php";
$q = $db->query("SELECT id,date,adminID FROM `ilanlar` WHERE status = 'ACTIVE' ORDER BY date DESC LIMIT 0,10");
$lastActives = $q->fetchAll(PDO::FETCH_ASSOC);