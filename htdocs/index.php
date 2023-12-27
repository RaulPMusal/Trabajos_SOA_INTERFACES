<?php
require_once('funciones.php');

//csv de prueba
$csv = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15
16,17,18,19,20,21,22,23,24,25,26,27,28,29,30
31,32,33,34,35,36,37,38,39,40,41,42,43,44,45";

$resultado = reducirDimensiones($csv);

//descargar el archivo cuando se presiona el boton de descarga
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csv'])) {
  $csv = $_POST['csv'];

  //encabezado para descargar el archivo
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="download.csv"');
  
}
?>

<form method="post" name="descarga">
    <input type="hidden" name="csv" value="<?php echo $resultado; ?>">
    <input type="submit" value="Descargar CSV">
</form>
