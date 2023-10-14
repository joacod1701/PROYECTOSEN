from flask import Flask, request, jsonify
import cv2
import numpy as np

app = Flask(__name__)

@app.route('/calcular_porcentajes', methods=['POST'])
def calcular_porcentajes():
    if request.method == 'POST':
        # Obtén el archivo de imagen del formulario
        uploaded_image = request.files['image']
        
        if uploaded_image:
            # Guarda la imagen en una ubicación temporal
            image_path = 'temp.jpg'
            uploaded_image.save(image_path)
            
            # Llama a la función para calcular los porcentajes
            percentages = calcular_porcentajes_zonas_oscuro_claro(image_path)
            
            # Devuelve los resultados en formato JSON
            return jsonify({"percentage_dark": percentages[0], "percentage_light": percentages[1]})

def calcular_porcentajes_zonas_oscuro_claro(image_path):
    # Lee la imagen en escala de grises
    image = cv2.imread(image_path, cv2.IMREAD_GRAYSCALE)

    # Aplica un umbral adaptativo local con método Gaussiano
    binary_image = cv2.adaptiveThreshold(image, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY, 25, 10)

    # Invierte los colores para que el fondo sea oscuro y los objetos sean claros
    inverted_image = cv2.bitwise_not(binary_image)

    # Cuenta los píxeles en las zonas de color oscuro y claro
    total_pixels = image.size
    pixels_dark = np.sum(binary_image == 0)
    pixels_light = np.sum(binary_image == 255)

    # Calcula los porcentajes
    percentage_dark = (pixels_dark / total_pixels) * 100
    percentage_light = (pixels_light / total_pixels) * 100

    return (percentage_dark, percentage_light)

if __name__ == '__main__':
    app.run(debug=True)
