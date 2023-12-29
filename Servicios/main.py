from fastapi import Request, FastAPI
import json
from pca import reduccionPSA
from tsne import reduccionTSNE

app = FastAPI()

@app.post("/apilineal")
async def lineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    strJson = await request.body()
    strJson = strJson.decode('utf-8') #codificar como json string

    #Aqui se procesan los datos
    print(strJson)
    jsonReducido = reduccionPSA(strJson)
    
    return jsonReducido

@app.post("/apinolineal")
async def nolineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    strJson = await request.body()
    strJson = strJson.decode('utf-8') #codificar como json string

    #Aqui se procesan los datos
    jsonReducido = reduccionTSNE(strJson)

    return jsonReducido
