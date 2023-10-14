<!DOCTYPE html>
<html>
<head>
    <title>Procesamiento de Imágenes SATELITALES</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        #result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Procesamiento de Imágenes SATELITALES</h1>
        <form id="image-upload-form" class="mt-4" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Selecciona una imagen:</label>
                <input type="file" class="form-control-file" name="image" id="image" accept=".jpg, .jpeg, .png">
            </div>
            <button type="submit" class="btn btn-primary">Procesar</button>
            <a href="index.php" class="btn btn-primary">refrescar</a>
        </form>

        <div id="result" class="mt-4"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#image-upload-form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: 'procesar_imagen.php', // Ruta al script PHP de procesamiento
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#result').html(data);
                    }
                });
            });
        });
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
