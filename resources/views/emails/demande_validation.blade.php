<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de création de compte</title>
</head>
<body>
    <h1>Nouvelle demande de création de compte</h1>
    <p>Nom : {{ $name }}</p>
    <p>Email : {{ $email }}</p>
    <p>Résumé : {{ $resume }}</p>

    <p>
        <a href="{{ $validation_url }}" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none;">
            Valider la création du compte
        </a>
    </p>
</body>
</html>
