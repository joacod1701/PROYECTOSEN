<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $url = 'http://localhost:5000/calcular_porcentajes'; // Cambia la URL según la configuración de tu servidor Flask
    $file = $_FILES['image'];

    $data = [
        'image' => new CURLFile($file['tmp_name'], $file['type'], $file['name']),
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $results = json_decode($response, true);

    if ($results) {
        echo '<div id="result" class="mt-4 text-center">';
        echo '<div style="max-width: 400px; max-height: 400px; overflow: hidden;">'; // Controlar el tamaño de la imagen
        echo '<img id="processed-image" src="temp.jpg" alt="Imagen procesada" style="width: 100%; height: auto;">'; // Establecer estilos para controlar el tamaño
        echo '</div>';
        echo '</div>';
        echo '<div class="container mt-4">';
        echo '<div class="alert alert-success" role="alert">';
        echo "<h4 class='alert-heading'>Resultados:</h4>";
        echo "Porcentaje de Deforestación: <span class='badge badge-danger'>{$results['percentage_dark']}%</span><br>";
        echo "Porcentaje de Forestación: <span class='badge badge-success'>{$results['percentage_light']}%</span>";
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="container mt-4">';
        echo '<div class="alert alert-danger" role="alert">';
        echo "<h4 class='alert-heading'>Error:</h4>";
        echo "Error al obtener resultados.";
        echo '</div>';
        echo '</div>';
    }
}
?>
