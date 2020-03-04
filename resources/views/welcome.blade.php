<!doctype html>
<html lang="en">

<head>
  <!--   meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('bootstrap-4.4.1-dist/css/bootstrap.min.css') }}">

  <title>Hello</title>
</head>

<body>

  <div class="container">
    <h1>Contact me</h1>
  <a href="{{ route('fluid_show') }}">Jquery Form</a>
    <br>
    @if ($mess ?? '')
    <div class="alert alert-success">
      <small id="message">
        {{ $mess ?? '' }}
      </small>
    </div>
    @endif
    <form method="POST" action="{{ route('save') }}">
      @csrf
      <div class="form-row ">
        <div class="col-md-4 mb-3">
          <label for="firstname">First name</label>
          <input type="text" name="firstname" class="form-control {{ $errors->has('firstname') ? ' is-invalid' : '' }}"
            id=" firstname" placeholder="First name">
          <div class="invalid-feedback">
            @if ($errors->has('firstname'))
            {{ $errors->first('firstname') }}
            @endif
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="lastname">Last name</label>
          <input type="text" name="lastname" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
            id="lastname" placeholder="Last name">
          <div class="invalid-feedback">
            @if ($errors->has('lastname'))
              {{ $errors->first('lastname') }}
            @endif
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="username">Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupPrepend">@</span>
            </div>
            <input type="text" name="username" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" placeholder="Username"
              aria-describedby="inputGroupPrepend">
              <div class="invalid-feedback">
                @if ($errors->has('username'))
                  {{ $errors->first('username') }}
                @endif
              </div>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label for="validationCustom03">City</label>
          <input type="text" name="city" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" id="city" placeholder="City">
          <div class="invalid-feedback">
            @if ($errors->has('city'))
              {{ $errors->first('city') }}
            @endif
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <label for="state">State</label>
          <input type="text" name="state" class="form-control {{ $errors->has('state') ? ' is-invalid' : '' }}" id="state" placeholder="State">
          <div class="invalid-feedback">
            @if ($errors->has('state'))
              {{ $errors->first('state') }}
            @endif
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <label for="zip">Zip</label>
          <input type="text" name="zip" class="form-control {{ $errors->has('zip') ? ' is-invalid' : '' }}" id="zip" placeholder="Zip">
          <div class="invalid-feedback">
            @if ($errors->has('zip'))
              {{ $errors->first('zip') }}
            @endif
          </div>
        </div>
      </div>
      <button class="btn btn-primary btn-sm" type="submit">Submit form</button>
    </form>
  </div>


  <!-- Optional JavaScript -->
  <script>

  </script>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="{{ asset('jquery/jquery-3.2.1.slim.min.js') }} "></script>
  <script src="{{ asset('ajax/popper.min.js') }} "></script>
  <script src="{{ asset('bootstrap-4.4.1-dist/js/bootstrap.min.js') }}"></script>
</body>

</html>