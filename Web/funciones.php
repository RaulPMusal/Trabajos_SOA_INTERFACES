<?php

//clase para comprobar si el csv a enviar es válido
class CsvUsuario{
  public $csvArray = array();
  public $datos = NULL;
  public $encabezado = NULL;
  public $errores = array();
  public $resultado = NULL;
  public $varianza = NULL;
  public $metodo = NULL;

  /**
   * Función que convierte un string csv en una matriz para enviarlo al servicio
   */
  public function csvStringAarray($csvString) {
    //Normalizar los saltos de linea del csv
    $csvString = str_replace("\r\n", "\n", $csvString);
    $csvString = str_replace("\r", "\n", $csvString);
    //Eliminar el salto de linea final si existe
    $csvString = rtrim($csvString, "\n");

    //Separar el csv en filas
    $filas = explode("\n", $csvString);

    //Formatear los valores de cada fila en un array
    foreach ($filas as $fila) {
      $nfila = str_getcsv($fila);
      $this->csvArray[] = $nfila;
    }
  }

  //funcion para verificar si el csv tiene encabezado
  public function tieneEncabezado(){
    //verificar si el csv tiene encabezado
    if(is_array($this->datos) && count($this->datos) > 0){
      $encabezado = $this->datos[0];
      //verificar si el encabezado es un array
      if(is_array($encabezado)){
        //verificar si el encabezado tiene valores
        if(count($encabezado) > 0){
          //verificar si el encabezado tiene valores numericos
          if(is_numeric($encabezado[0])){
            return false;
          }
          else{
            return true;
          }
        }
        else{
          return false;
        }
      }
      else{
        return true;
      }
    }
    else{
      return false;
    }
  }

  //funcion para leer el csv del usuario y procesarlo
  public function leerCsvUsuario($csv){
    //se convierte el csv a un array
    $this->csvStringAarray($csv);
    $this->datos = $this->csvArray;
    
    //verificar si el csv tiene encabezado
    if(is_array($this->datos) && $this->tieneEncabezado()){
      //extraer el encabezado del csv
      $this->encabezado = array_shift($this->datos);
      
    }
    //recorrer $this->datos y verificar si todos los elementos son numericos
    foreach ($this->datos as $fila) {
      foreach ($fila as $valor) {
        //verificar si el valor no es numerico
        if(!is_numeric($valor)){
          $this->errores[] = "El csv contiene valores no numéricos o la matriz no es simétrica";
          return;
        }
      }
    }
    //cambiar el tipo de datos de todos los valores en $this->datos a float
    foreach ($this->datos as &$fila) {
      foreach ($fila as &$valor) {
        $valor = floatval($valor);
      }
    }

  }

  /**
  * Función que envía el json con los datos del csv a un servicio para reducir sus dimensiones
  */
  public function reducirDimensiones($servicio = 'lineal'){

    //direccion del endpoint del esb
    $url = 'http://localhost:8080/esbEndpoint';
    $ch = curl_init($url);

    //la cabecera indica el servicio a utilizar
    $headers = [
      'serv: ' . $servicio,
      'Content-Type: application/json',
    ];

    //se envia el csv y el encavezado por post utilizando curl
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    $json = json_encode(['datos' => $this->datos]); //se codifican los datos como json
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json); //se envia el json como cuerpo del post
    $response = curl_exec($ch);
    curl_close($ch);

    //verificar si la respuesta es un json válido
    $respuesta = new Respuesta($response, $this);
    $respuesta->procesarRespuesta(); //se procesa la respuesta del servicio
    if($respuesta->resultados != NULL){
      $respuesta->convertirRespuestaAcsv(); //se convierte la respuesta a csv string
      $this->resultado = $respuesta->csvReducido; //se guarda el csv string en la clase
      $this->varianza = $respuesta->varianza; //se guarda la varianza en la clase
      $this->metodo = $respuesta->metodo; //se guarda el metodo utilizado en la clase
    }
    $this->errores = array_merge($this->errores, $respuesta->errores); //agregar errores de la respuesta a los errores de la clase
  }

}

//clase para procesar el csv a enviar y la respuesta recibida del servicio
class Respuesta{
  public $jsonRecibido = NULL;
  public $resultados = NULL;
  public $datos = NULL;
  public $varianza = NULL;
  public $errores = array();
  public $csvReducido = NULL;
  public $csvUsuario = NULL;
  public $metodo = NULL;

  public function __construct($jsonString, $csvUsuario){
    $this->jsonRecibido = json_decode($jsonString, true);
    $this->csvUsuario = $csvUsuario;
  }

  //funcion que procesa la respuesta recibida y comprueba si hay errores
  public function procesarRespuesta(){
    //verificar si no se ha podido decodificar la respuesta como json
    if($this->jsonRecibido == NULL ){
      $this->errores[] = "Se ha producido un error al intentar procesar los datos introducidos";
    }
    //verificar si se han recibido resultados
    if(isset($this->jsonRecibido['resultados'])){
      $this->resultados = $this->jsonRecibido['resultados'];
      //verificar si se ha recibido la varianza
      if(isset($this->jsonRecibido['varianza'])){
        $this->varianza = $this->jsonRecibido['varianza'];
      }
    }
    //verificar si se ha recibido un error del servicio
    else if(isset($this->jsonRecibido['error_method'])){
      $this->errores[] = $this->jsonRecibido['error_method'];
    }
    //guardar el metodo utilizado en la clase
    if(isset($this->jsonRecibido['metodo'])){
      $this->metodo = $this->jsonRecibido['metodo'];
    }
  }

  /**
  * Función que convierte un json string a csv  para mostrarlo en la web
  */
  public function convertirRespuestaAcsv(){

    //se abre un archivo temporal
    $csvTemp = fopen('php://temp', 'r+');

    //se escriben los datos del array en un archivo csv temporal
    foreach ($this->resultados as $fila) {
      fputcsv($csvTemp, $fila);
    }

    //colocar el apuntador al principio del archivo
    rewind($csvTemp);

    //guardar el csv escrito como string
    $this->csvReducido = stream_get_contents($csvTemp);
    

    fclose($csvTemp);
  }

}
