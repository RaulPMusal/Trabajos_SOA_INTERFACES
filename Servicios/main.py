from fastapi import Request, FastAPI
import json
from pca import reduccionPCA
from tsne import reduccionTSNE

app = FastAPI()

@app.post("/apilineal")
async def lineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    strJson = await request.body()
    strJson = strJson.decode('utf-8') #codificar como json string

    #Aqui se procesan los datos
    print(f'Se recibe: {strJson}')
    jsonReducido = reduccionPCA(strJson)
    
    print(f'Se devuelve: {jsonReducido}')
    return jsonReducido

@app.post("/apinolineal")
async def nolineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    strJson = await request.body()
    strJson = strJson.decode('utf-8') #codificar como json string

    #Aqui se procesan los datos
    print(f'Se recibe: {strJson}')
    jsonReducido = reduccionTSNE(strJson)

    print(f'Se devuelve: {jsonReducido}')
    return jsonReducido
