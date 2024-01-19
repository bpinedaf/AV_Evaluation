import requests

def identify_crop(photo, crop):
    # Llama a la API de identificación de cultivos de Plantix
    url = "https://api.plantix.com/v2/crops"
    data = {
        "image": photo,
        "crop": crop,
    }
    response = requests.post(url, json=data, headers={"Authorization": "Bearer 2b0080cfd58f564046a1104db36c9163091c2a07"})

    # Devuelve el resultado de la API
    return response.json()

# Obtiene los datos del formulario
nombre_foto = request.args.get("nombre_foto")
cultivo = request.args.get("cultivo")

# Llama a la función para identificar el cultivo
respuesta = identify_crop(photo=nombre_foto, crop=cultivo)

# Devuelve el resultado a la página web
return respuesta
