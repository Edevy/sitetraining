<!doctype html>
<html lang="en">

<head>
    <!--   meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap-4.4.1-dist/css/bootstrap.min.css') }}">

    <title>Hello</title>
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Other way to Contact me</h1>
        <a href="/">Native Form</a>
        <br>
        <div class="alert" style="display:none">
            <small id="message">
            </small>
        </div>
        <form id="contact" method="POST" action="javascript:void(0)">
            @csrf
            <div class="form-row ">
                <div class="col-md-4 mb-3">
                    <label for="firstname">First name</label>
                    <input type="text" name="firstname" class="form-control " id="firstname" placeholder="First name">
                    <div class="invalid-feedback invalid-firstname">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="lastname">Last name</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last name">
                    <div class="invalid-feedback invalid-lastname">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                        </div>
                        <input type="text" name="username" class="form-control " id="username" placeholder="Username"
                            aria-describedby="inputGroupPrepend">
                        <div class="invalid-feedback invalid-username">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationCustom03">City</label>
                    <input type="text" name="city" class="form-control " id="city" placeholder="City">
                    <div class="invalid-feedback invalid-city">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="state">State</label>
                    <input type="text" name="state" class="form-control " id="state" placeholder="State">
                    <div class="invalid-feedback invalid-state">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="zip">Zip</label>
                    <input type="text" name="zip" class="form-control " id="zip" placeholder="Zip">
                    <div class="invalid-feedback invalid-zip">
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-sm" type="submit">Submit form</button>
        </form>
    </div>


    <!-- Optional JavaScript -->
    <script>
        $(document).ready(function () {
      $('#contact').submit(function (e) { 
        // page doesn't load
        e.preventDefault();

       $.ajax({
         type: "POST",
         url: "{{route('fluid_save')}}",
         data: new FormData(this),
         dataType: "json",
         processData : false,
         contentType : false,
         cache : false,
         success: function (response) {
            if(response.warning){
                $.each(response.warning, function (index, value) { 
                  // console.log(index +" ---> " +value)
                    $('input[name='+index+']').addClass('is-invalid')
                    $('.invalid-'+index+'').append(value)

                    $('input[name='+index+']').keydown(function (e) { 
                        $(this).removeClass('is-invalid')
                        $('.invalid-'+index+'').empty()
                    });

                    $('input[name='+index+']').empty(function(e){
                      $(this).addClass('is-invalid')
                    });

                });
            }

            if(response.success){
                $('.alert')
                .css('display','block')
                .addClass('alert-'+response.success.status+'')
                .append(response.success.message)
            }
            if(response.error){
                console.log(response.error)
            }
         }
       });
        
      });
  });
    </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('ajax/popper.min.js') }} "></script>
    <script src="{{ asset('bootstrap-4.4.1-dist/js/bootstrap.min.js') }}"></script>
</body>

</html>