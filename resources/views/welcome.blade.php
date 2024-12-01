<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Binarizar Imagem</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #4a5568;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #4a5568;
            margin-bottom: 8px;
            text-align: left;
        }

        input[type="file"], input[type="range"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3182ce;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2b6cb0;
        }

        .preview-container {
            margin-top: 20px;
        }

        .preview-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            margin-top: 20px;
        }

        .slider-container {
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Binarizar Imagem</h1>

        <form action="{{ url('/binarize-image') }}" method="POST" enctype="multipart/form-data" id="imageForm">
            @csrf
            <label for="image">Escolha uma imagem:</label>
            <input type="file" name="image" id="image" required>
            <div class="slider-container">
                <label for="threshold">Limiar de Binarização:</label>
                <input type="range" id="threshold" min="0" max="255" value="128" step="1">
                <span id="thresholdValue">128</span>
            </div>
            <button type="submit">Binarizar</button>
        </form>

        <div class="preview-container" id="imagePreviewContainer">
            <img id="previewImage" src="#" alt="Imagem binarizada" />
        </div>
    </div>

    <script>
        const form = document.getElementById('imageForm');
        const imageInput = document.getElementById('image');
        const previewImage = document.getElementById('previewImage');
        const thresholdSlider = document.getElementById('threshold');
        const thresholdValue = document.getElementById('thresholdValue');
        const previewContainer = document.getElementById('imagePreviewContainer');

        thresholdSlider.addEventListener('input', function() {
            thresholdValue.textContent = thresholdSlider.value;
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData();
            const file = imageInput.files[0];
            formData.append('image', file);
            formData.append('threshold', thresholdSlider.value);

            fetch('{{ url("/binarize-image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.blob())
            .then(blob => {
                const imageUrl = URL.createObjectURL(blob);
                previewImage.src = imageUrl;
                previewImage.style.display = 'block';
            })
            .catch(error => {
                console.error('Erro ao binarizar imagem:', error);
            });
        });
    </script>
</body>
</html>
