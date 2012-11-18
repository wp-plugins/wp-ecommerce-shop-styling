<?php
    require_once($_GET['dompdf']);    
    
    $path=$_GET["path"];

    $pdf = new DOMPDF();
    $pdf->set_paper($_GET['paper']);
    $pdf->load_html_file($path);
    $pdf->render();
    unlink($path); 
    $pdf->stream($_GET['filename']);
