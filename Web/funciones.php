<?php

/**
 * Función que convierte un json string a csv 
 * @param $jsonString string json a convertir
 */
function convertirRespuestaAcsv($jsonString)
{
  //Se obtienen los resultados del json de respuesta
  $arr = json_decode($jsonString, true)['resultados'];

  //se abre un archivo temporal
  $csvTemp = fopen('php://temp', 'r+');

  //se escriben los datos del array en un archivo csv temporal
  foreach ($arr as $fila) {
      fputcsv($csvTemp, $fila);
  }

  //colocar el apuntador al principio del archivo
  rewind($csvTemp);

  //guardar el csv escrito como string
  $csvString = stream_get_contents($csvTemp);

  
  fclose($csvTemp);

  return $csvString;
}

/**
 * Función que envía un csv a un servicio para reducir sus dimensiones
 * @param $csv string csv a enviar
 * @param $servicio string nombre del servicio a consumir (lineal, nolineal)
 */
function reducirDimensiones($csv, $servicio = 'lineal')
{

  //direccion del endpoint del esb
  $url = 'http://localhost:8080/esbEndpoint';
  $ch = curl_init($url);

  //el encabezado indica el servicio a utilizar
  $headers = [
    'serv: ' . $servicio,
    'Content-Type: text/csv',
  ];

  //se envia el csv y el encavezado por post utilizando curl
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $csv);
  $response = curl_exec($ch);
  curl_close($ch);
  echo "Se recibe lo siguiente del servicio: ";//debug
  print_r($response);//debug
  $csvRes = convertirRespuestaAcsv($response);
  return $csvRes;
}

/**
 * Función que convierte un string csv a un array de arrays para enviarlo al servicio
 * @param $input string csv a convertir
 */
function csvStringAarray($input) {
  // Split the CSV input into rows
  $rows = explode(PHP_EOL, trim($input));
  // Initialize the result array
  $result = array();

  // Iterate through rows and split into columns
  foreach ($rows as $row) {
      $columns = array_map('intval', explode(",", trim($row)));
      $result[] = $columns;
  }

  return $result;
}