from fastapi import FastAPI

app = FastAPI()

@app.get("/apilineal")
async def lineal():
    #obtener el json de la llamada post

    #enviar el json a la funcion de la api lineal

    #retornar el json de la respuesta
    return {"mensaje": "apiLineal"};

@app.get("/apinolineal")
async def nolineal():
    #obtener el json de la llamada post

    #enviar el json a la funcion de la api linealx

    #retornar el json de la respuesta
    return {"mensaje": "apiNoLineal"};


