from fastapi import Request, FastAPI
import json
import pca
import tsne

app = FastAPI()

@app.post("/apilineal")
async def lineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    strJson = await request.body()
    strJson = strJson.decode('utf-8') #codificar como json string
    print(strJson)

    #Aqui se procesan los datos
    jsonReducido = tsne.TSNE(strJson)
    print(jsonReducido)
    
    return jsonReducido 

@app.post("/apinolineal")
async def nolineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    strJson = await request.body()
    strJson = strJson.decode('utf-8') #codificar como json string
    print(strJson)

    #Aqui se procesan los datos
    jsonReducido = tsne.TSNE(strJson)
    print(jsonReducido)
    
    return jsonReducido 
