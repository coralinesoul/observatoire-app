<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle étude créée</title>
</head>
<body>
    <h1>Nouvelle étude créée</h1>
    <p>L'utilisateur {{ $user }} a créé une nouvelle étude.</p>
    <p>Titre : {{ $title }}</p>
    <p><a href="{{ route('catalogue.find', ['slug' => $slug, 'etude' => $id]) }}">Voir l'étude</a></p>
</body>
</html>
