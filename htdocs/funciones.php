<?php

/**
 * Función que convierte un json string* a csv *es una especie de json string
 * @param $jsonString string json a convertir
 */
function convertirRespuestaAcsv($jsonString)
{

  //Decodifica el json string a un array de arrays
  $data = json_decode($jsonString);

  //Se escribe el array de arrays en un fichero en memoria
  $ficheroCsv = fopen('php://memory', 'w');

  //Se escribe cada fila en el fichero 
  foreach ($data as $fila) {
    fputcsv($ficheroCsv, $fila);
  }

  //Move the file pointer to the beginning of the "file" (in memory)
  rewind($ficheroCsv);

  //Se lee el fichero con el csv como string para devolverlo
  $csvString = stream_get_contents($ficheroCsv);

  fclose($ficheroCsv);
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
  //al recibir la respuesta se convierte a csv y se devuelve
  $csvRes = convertirRespuestaAcsv($response);
  return $csvRes;
}