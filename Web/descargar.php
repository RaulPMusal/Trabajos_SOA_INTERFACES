<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['csv'])) {
        
        $csv = base64_decode($_POST['csv']);

        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="download.csv"');

        echo $csv;
     
        exit;
    }
}
?>