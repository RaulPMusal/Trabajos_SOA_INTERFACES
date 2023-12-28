from fastapi import Request, FastAPI
import json

app = FastAPI()

@app.post("/apilineal")
async def lineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    data = await request.json() # Devuelve una lista de listas

    #Aqui se procesan los datos


    return data 

@app.post("/apinolineal")
async def nolineal(request: Request):
    # Se obtiene el json del cuerpo de la petición POST
    data = await request.json() # Devuelve una lista de listas

    #Aqui se procesan los datos

    
    return data 
