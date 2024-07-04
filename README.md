# Laravel CUBE Authentification

Le package permet de se connecter à l'API CUBE tout en gardant le système Auth de laravel

Pour publier
`php artisan vendor:publish --provider="Tchoblond59\CubeAuth\CubeApiUserProviderServiceProvider" --tag="config"`

Changer ensuite l'url cible dans le fichier `config/cube.php`

Dans le fichier `config/auth.php` changer les drivers de la section guard pour cube

````md
'guards' => [
        'web' => [
            'driver' => 'cube',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'cube',
            'provider' => 'users'
        ]
    ],
````

Puis dans la section providers:
````md
'providers' => [
'users' => [
'driver' => 'cube',
'model' => Tchoblond59\CubeAuth\Models\CubeUser::class,
],
'cube' => [
'driver' => 'cube',
'model' => Tchoblond59\CubeAuth\Models\CubeUser::class,
],
],
````
Deux middleware sont disponible afin de sécuriser les routes:
`EnsureTokenIsValid` et `HasCubeRole` qui permettent respectivement de vérifier qu'un token est valide et de vérifier si
l'utilisateur dispose bien d'un role.
Pour les utiliser:
 - Editer le fichier `bootstrap/app.php` et ajouter a la section middleware: 
`$middleware->alias(['hasRole' => \Tchoblond59\CubeAuth\Middlewares\HasCubeRole::class]);`
 - Vous pouvez ensuite pour protéger vos routes 
`Route::middleware(['auth', 'hasRole:OPERATEUR,SAV'])->get('/dashboard', function () {`

