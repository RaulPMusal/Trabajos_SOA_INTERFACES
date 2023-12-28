from fastapi import Request, FastAPI
import json
import pca
import tsne

app = FastAPI()

@app.post("/apilineal")
async def lineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    json = await request.json() # Devuelve una lista de listas

    #Aqui se procesan los datos
    jsonReducido = tsne(json)
    
    return jsonReducido 

@app.post("/apinolineal")
async def nolineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    json = await request.json() # Devuelve una lista de listas

    #Aqui se procesan los datos
    jsonReducido = pca(json)
    
    return jsonReducido 
