<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binarizar Imagem</title>
</head>
<body>
    <h1>Enviar Imagem para Binarizar</h1>

    <form action="{{ url('/binarize-image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" required>
        <button type="submit">Binarizar</button>
    </form>
</body>
</html>
