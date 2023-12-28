<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MatrixReducer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="container mt-4">

    <div class="jumbotron">
        <h1 class="display-4">MatrixReducer</h1>
        <p class="lead">Bienvenido a nuestra página de reducción de datos.</p>
        <hr class="my-4">
        <p>Esta página recoge una matriz de datos introducida por teclado o mediante la subida de un archivo CSV para reducirlos utilizando diferentes herramientas.</p>
    </div>

    <div class="container" style="margin: 30px 10px;">
        <h2>Instrucciones para Reducir Datos</h2>

        <p class="lead">Para reducir tus datos, sigue estos pasos:</p>

        <ol>
            <li>Selecciona la opción deseada para introducirlos.</li>
            <li>Selecciona el archivo CSV o introduce la matriz manualmente como se indica en el formato.</li>
            <li>Haz clic en el botón "Reducir Datos".</li>
        </ol>
    </div>

    <div style="background-color: #e9ecef; padding: 30px; margin: 10px 0px 10px 0px; border-radius: 5px;">

    <p class="lead">Escoge la opción:</p>

    <form id="formularioOpciones">
        <label style="margin-bottom: 10px;">
            <input type="radio" name="opcion" value="porTeclado" onclick="mostrarRespuesta('porTeclado')"> Introducir datos por teclado.
        </label>
        <br>
        <label>
            <input type="radio" name="opcion" value="porArchivo" onclick="mostrarRespuesta('porArchivo')"> Introducir datos mediante CSV.
        </label>
    </form>
    <br>

    <div id="respuestaA" style="display: none;">
        <form>
            <label for="datosPantalla" style="display: block; margin-bottom: 10px;">Introduce la matriz de datos a reducir por pantalla:</label>
            <input type="text" id="datosPantalla" name="datosPantalla" placeholder="[{a:x,b:y,c:z},{a:x,b:y,c:z}]" required style="padding: 5px; border-radius: 3px; border: 1px solid #ccc; margin-bottom: 10px;" />
            <br>
            <input type="button" value="Reducir Datos" onclick="manipularDatos('archivoCSV')" 
            style="padding: 5px 10px; background-color: #333; color: #fff; border-radius: 3px;" onmouseover="this.style.backgroundColor='#555'" onmouseout="this.style.backgroundColor='#333'">
        </form>
    </div>

    <div id="respuestaB" style="display: none;">
        <form>
            <label for="archivoCSV" style="display: block; margin-bottom: 10px;">Selecciona la matriz de datos a reducir (CSV):</label>
            <input type="file" id="archivoCSV" name="archivoCSV" accept=".csv" style="margin-bottom: 10px;" />
            <br>
       <input type="button" value="Reducir Datos" onclick="manipularDatos('archivoCSV')" 
            style="padding: 5px 10px; background-color: #333; color: #fff; border-radius: 3px;" onmouseover="this.style.backgroundColor='#555'" onmouseout="this.style.backgroundColor='#333'">
        </form>
    </div>
</div>


    <script>
        function mostrarRespuesta(opcion) {
            var respuestaA = document.getElementById('respuestaA');
            var respuestaB = document.getElementById('respuestaB');

            if (opcion === 'porTeclado') {
                respuestaA.style.display = 'block';
                respuestaB.style.display = 'none';
            } else if (opcion === 'porArchivo') {
                respuestaA.style.display = 'none';
                respuestaB.style.display = 'block';
            }
        }

        function manipularDatos(opcion) {
            var respuestaA = document.getElementById('respuestaA');
            var respuestaB = document.getElementById('respuestaB');

            if (opcion === 'datosPantalla') {
                //comprobar que los datos entran con el formato, si no, convertir o mostrar error ??
                //usar funcion para convertir a csv
                //enviar csv para reducir

            } else if (opcion === 'archivoCSV') {
                //enviar csv para reducir
            }
        }
    </script>

    </div>

    <footer style="background-color: #333; color: #fff; text-align: center; padding: 10px; border-radius: 5px;">
        <p>&copy; 2023 DataReducer. Arquitectura Orientada a Servicios. Raúl Peña, Miguel Iñesta, Elsa Alberca y Alba Martínez</p>
    </footer>
</body>
</html>
