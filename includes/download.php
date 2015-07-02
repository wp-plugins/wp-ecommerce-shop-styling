<?php
ob_start();
require_once(__DIR__."/../../../../wp-admin/admin.php");
ob_end_clean ();
header('Content-disposition: attachment; filename='.$_GET['filename']);
header('Content-type: application/pdf');
readfile(HAET_INVOICE_PATH.$_GET['filename']);
?> 