# LIBRERIAS
import json
import numpy as np
import pandas as pd
from sklearn.preprocessing import StandardScaler 
from sklearn.decomposition import PCA  # to apply PCA
from sklearn.manifold import TSNE



"""
    FUNCIÓN QUE APLICARÁ PCA (Principal Component Analysis) PARA REDUCCIÓN DE LA DIMENSIÓN DE DATOS
    
    PARÁMETROS
    * matriz_datos : matriz tipo Numpy con los datos a reducir
    
    RETORNO
    * datos reducidos
"""
def reduccion_dimension_PCA(matriz_datos):
    
    # Escalamos los datos para que puedan ser comparados
    X = StandardScaler().fit_transform(matriz_datos)
    # Crear objeto del algoritmo PCA        
    # Al poner el parámetro n_componets = 'mle' se usará Minka’s MLE para predecir la dimensión de los datos de salida de forma automática.
    pca = PCA(n_components = 'mle')
    # Ajustar los datos al modelo y reducir estos
    resultados_pca = pca.fit_transform(X)
    # Convertir los resultados de PCA a listas de Python
    resultados_pca = resultados_pca.tolist()
    
    # Calcular la varianza y convertir a listas de Python
    # Indica cuánta varianza en los datos es capturada por cada componente principal.
    varianza = pca.explained_variance_ratio_.tolist()
    
    # Crear el resultado en formato JSON y devolver
    resultado_final_auto = {
        'resultados': resultados_pca,
        'varianza': varianza,
    }
    

    return json.dumps(resultado_final_auto)



"""
    FUNCIÓN PRINCIPAL
    
    PARÁMETROS
    * datos_json : datos recibidos del usuaio
    
    RETORNO
    * resultado json con los datos reducidos y/o mensaje para el usuario
"""
def reduccionPSA(datos_json):
    
    # Cargar datos del JSON y convertir a un diccionario Python
    datos_dict = json.loads(datos_json)

    # Convertir los datos del diccionario (strings) en floats (números)
    #datos_dict['datos'] = [[float(num) for num in sublista] for sublista in datos_dict['datos']]
    
    # Convertir los datos a reducir a una matriz NumPy
    datos_array = np.array(datos_dict['datos'])
    
    # Obtener el método de reducción de dimensión elegido por el usuario
    #metodo_reduccion = datos_dict['metodo']
      
    # Ver el tipo de datos a reducir (True si son todos los datos numéricos | False si no)
    tipo_datos = np.all([np.issubdtype(type(x), np.number) for x in np.ravel(datos_array)])
        
    # Si NO son todos los datos numéricos
    if tipo_datos != True:
            
        # Crear un JSON de respusta y lo devolvemos
        resultado_final = {
            'datos': datos_dict['datos'], # datos originales
            #'metodo': datos_dict['metodo'], # metodo erroneo dado
            'error_method': "DATOS NO SOPORTADOS" #indicacion del error
        }
        return resultado_final
    
    # Si son todos los datos numéricos
    else:

        # Llamar al método correspondiente con los datos a reducir
        resultado_final = reduccion_dimension_PCA(datos_array)
        # Devolver el JSON generado
        return resultado_final