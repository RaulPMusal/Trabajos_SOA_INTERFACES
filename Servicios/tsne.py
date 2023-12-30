# LIBRERIAS
import json
import numpy as np
import pandas as pd
from sklearn.preprocessing import StandardScaler 
from sklearn.manifold import TSNE



"""
    FUNCIÓN QUE APLICARÁ TSNE (t-distribución de Stochastic Neighbor Embedding) PARA REDUCCIÓN DE LA DIMENSIÓN DE DATOS
    
    PARÁMETROS
    * matriz_datos : matriz tipo Numpy con los datos a reducir
    
    RETORNO
    * datos reducidos
"""
def reduccion_dimension_TSNE(matriz_datos):
    
    # Escalamos los datos para que puedan ser comparados
    X = StandardScaler().fit_transform(matriz_datos)
    #Calculamos el número adecuado para el parámetro perplexity del TSNE que indicará el número de "vecinos cercanos"
    param_p = matriz_datos.shape[0] // 2
    # Crear objeto del algoritmo TSNE        
    if param_p < 30:
        tsne = TSNE(perplexity=param_p) #hacemos la llamada con el parametro calculado
    else:
        tsne = TSNE() #hacemos la llamada con el parametro default que es =30

    # Ajustar los datos al modelo y reducir estos
    resultados_tsne = tsne.fit_transform(X)
    # Convertir los resultados de TSNE a listas de Python
    resultados_tsne = resultados_tsne.tolist()
    
    # Crear el resultado en formato JSON y devolver
    resultado_final_auto = {
        'resultados': resultados_tsne,
        'metodo': 'TSNE'
    }
    
    return resultado_final_auto

"""
    FUNCIÓN PRINCIPAL
    
    PARÁMETROS
    * datos_json : datos recibidos del usuaio
    
    RETORNO
    * resultado json con los datos reducidos y/o mensaje para el usuario
"""
def reduccionTSNE(datos_json):
    
    # Cargar datos del JSON y convertir a un diccionario Python
    datos_dict = json.loads(datos_json)

    # Convertir la lista de listas a una matriz NumPy
    datos_array = np.array(datos_dict['datos'])  
      
    # Ver el tipo de datos a reducir (True si son todos los datos numéricos | False si no)
    tipo_datos = np.all([np.issubdtype(type(x), np.number) for x in np.ravel(datos_array)])
        
    # Si NO son todos los datos numéricos
    if tipo_datos != True:
            
        # Crear un JSON de respusta y lo devolvemos
        resultado_final = {
            'datos': datos_dict['datos'], # datos originales
            'error_method': "DATOS NO SOPORTADOS" #indicacion del error
        }
        return resultado_final
    
    # Si son todos los datos numéricos
    else:

        # Llamar al método correspondiente con los datos a reducir
        resultado_final = reduccion_dimension_TSNE(datos_array)
        # Devolver el JSON generado
        return resultado_final
