@author Bynan

# Ici nous allons détailler la fonction INSERT natif de laravel et avec JQuery

Configuration de la base de donnée :

-   créer un base de donnée vide sous le nom de 'goha'
-   modifier le fichier .env dans la racine du projet

```
    DB_DATABASE=goha
    DB_USERNAME=[mon nom d'utilisateur de la base]
    DB_PASSWORD=[mon mot de passe]
```

-   remplacer les codes dans welcome.blade.php par:

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS -->
        <link
            rel="stylesheet"
            href="{{ asset('bootstrap-4.4.1-dist/css/bootstrap.min.css') }}"
        />

        <title>Hello, world!</title>
    </head>
    <body>
        <h1>Hello, world!</h1>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="{{ asset('jquery/jquery-3.2.1.slim.min.js') }} "></script>
        <script src="{{ asset('ajax/popper.min.js') }} "></script>
        <script src="{{ asset('bootstrap-4.4.1-dist/js/bootstrap.min.js') }}"></script>
    </body>
</html>
```

-   puis mettez dans le dossier public de la racine :

    -   /bootstrap-4.4.1-dist/\*
    -   /jquery/\*
    -   /ajax/\*

-   ajouter le formulaire

```html
<div class="container">
    <h1>Contact me</h1>
    <form>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="firstname">First name</label>
                <input
                    type="text"
                    name="firstname"
                    class="form-control"
                    id="firstname"
                    placeholder="First name"
                />
            </div>
            <div class="col-md-4 mb-3">
                <label for="lastname">Last name</label>
                <input
                    type="text"
                    name="lastname"
                    class="form-control"
                    id="lastname"
                    placeholder="Last name"
                />
            </div>
            <div class="col-md-4 mb-3">
                <label for="username">Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend"
                            >@</span
                        >
                    </div>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        id="username"
                        placeholder="Username"
                        aria-describedby="inputGroupPrepend"
                    />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="city">City</label>
                <input
                    type="text"
                    name="city"
                    class="form-control"
                    id="city"
                    placeholder="City"
                />
            </div>
            <div class="col-md-3 mb-3">
                <label for="state">State</label>
                <input
                    type="text"
                    name="state"
                    class="form-control"
                    id="state"
                    placeholder="State"
                />
            </div>
            <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input
                    type="text"
                    name="zip"
                    class="form-control"
                    id="zip"
                    placeholder="Zip"
                />
            </div>
        </div>
        <button class="btn btn-primary btn-sm" type="submit">
            Submit form
        </button>
    </form>
</div>
```

-   ajouter la balise @csrf et les actions de la balise form

```html
<form method="POST" action="{{ route('save') }}">
    @csrf
    <div class="form-row">
        <div class="col-md-4 mb-3"></div>
        ...
    </div>
</form>
```

-   créer le contrôlleur pour gerer l'ajout

    **_php artisan make:controller FormController_**

    -   ajouter ces lignes de codes dans la fonction save()

```php
function save(Request $request){
        $request->validate(
        [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:contacts',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric'
        ]);
    }
```

### Ce n'est pas encore fini, il nous reste à créer les tables et les modèles

Créons notre modèle:  
 **_php artisan make:model Contact -m_**  
Puis ajouter ces lignes de codes dans le modèle:

```php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'city',
        'state',
        'zip'
    ];
}
```

Puis intéressons nous sur notre migration fraîchement crée XXXXXXXXX_create_contacts_table.php :

Ajouter dans la fonction up():

```php
 public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->timestamps();
        });
    }
```

Puis taper la commande suivante pour migrer la structure de notre base de données :  
**_php artisan migrate_**

Ajouter cela à la dernière ligne de notre fonction:

```php
try {
    Contact::create($datas);
    $mess = "Ajouté avec succès";
    return view('/', compact('mess'));
} catch (\Throwable $th) {
    throw $th;
}
```

Retourner les valeurs d'erreurs à la formulaire:

```html
...
<div class="container">
    <h1>Contact me</h1>
    <br />
    @if ($mess ?? '')
    <div class="alert alert-success">
        <small id="message">
            {{ $mess ?? '' }}
        </small>
    </div>
    <form method="POST" action="{{ route('save') }}">
        @csrf
        <div class="form-row ">
            <div class="col-md-4 mb-3">
                <label for="firstname">First name</label>
                <input
                    type="text"
                    name="firstname"
                    class="form-control {{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                    id=" firstname"
                    placeholder="First name"
                />
                <div class="invalid-feedback">
                    @if ($errors->has('firstname')) {{
                    $errors->first('firstname') }} @endif
                </div>
                ...
            </div>
        </div>
    </form>
</div>
```

## La validation avec JQuery

-   Enlever toutes les snippets blade
-   changer le message en display: none

```html
<div class="alert" style="display:none">
    <small id="message"> </small>
</div>
```

Ajouter les fichiers correspondants à la validation ajax

```html
 <title>Hello</title>
    <script src="{{ asset('jquery/jquery.js') }}"></script>
</head>
```

Taper jqready dans le partie script en bas (assummant que jquery snippets est installé sous VS Code)

```js
$(document).ready(function() {});
```

Modifier ici

```html
...
<form id="contact" method="POST" action="javascript:void(0)">
    ...
    <div class="invalid-feedback invalid-username"></div>
    ...
</form>
```

Puis :

```js
$(document).ready(function() {
    $("#contact").submit(function(e) {
        // page doesn't load
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "{{route('fluid_save')}}",
            data: new FormData(this),
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                if (response.warning) {
                    $.each(response.warning, function(index, value) {
                        // console.log(index +" ---> " +value)
                        $("input[name=" + index + "]").addClass("is-invalid");
                        $(".invalid-" + index + "").append(value);

                        $("input[name=" + index + "]").keydown(function(e) {
                            $(this).removeClass("is-invalid");
                            $(".invalid-" + index + "").empty();
                        });

                        $("input[name=" + index + "]").empty(function(e) {
                            $(this).addClass("is-invalid");
                        });
                    });
                }

                if (response.success) {
                    $(".alert")
                        .css("display", "block")
                        .addClass("alert-" + response.success.status + "")
                        .append(response.success.message);
                }
                if (response.error) {
                    console.log(response.error);
                }
            }
        });
    });
});
```

Dans le contrôlleur:

```php
/***
     *
     *
     * Fonction sauvegarder avec JQuery
     */
    function saveJquery(Request $req){
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:contacts',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails()){
            return response()->json([
                'warning'=>$validate->errors()
            ]);
        }

        $datas = [
            'firstname' => $req->firstname,
            'lastname' => $req->lastname,
            'username' => $req->username,
            'city' => $req->city,
            'state' => $req->state,
            'zip' => $req->zip
        ];

        try {
            Contact::create($datas);
            return response()->json([
                'success'=>[
                    'status'=>'success',
                    'message'=>'Data added with status success'
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error'=>$th->getMessage()
            ]);
        }


    }
```
