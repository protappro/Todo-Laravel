<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.87.0">
  <title>Signin Template · Bootstrap v5.1</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">



  <!-- Bootstrap core CSS -->
  <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }
    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="{{ asset('/css/signin.css') }}" rel="stylesheet">
</head>
<body>

  <main class="form-signin">
    <form action="{{ route('auth.authenticate') }}" method="POST" class="text-center">
      @csrf
      <img class="mb-4" src="https://cdn-jhioh.nitrocdn.com/VteKoLCwJwvBFPJxejdBktiSnzeaUJLY/assets/images/optimized/rev-f7a2cbf/magicminds.io/wp-content/uploads/2023/09/Logo.svg" alt="" width="250" height="auto">
      <h1 class="h3 mb-1 fw-normal">Sign in</h1>
      <small class="text-muted">Enter your email and password</small>

      <div class="form-floating mt-3">
        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email" placeholder="name@example.com">
        <label for="email">Email address</label>
        @error('email')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-floating">
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
        <label for="password">Password</label>
        @error('password')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="form-group d-flex justify-content-between align-items-center flex-wrap mb-3">
        <span class="font-weight-bold text-dark-50">Dont have an account yet?</span>
        <a href="{{ route('auth.register') }}" class="font-weight-bold my-3 mr-2 text-decoration-none">Sign Up!</a>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>

    </form> 
    <hr/>
    <div class="text-left">
      For Demo Login : 
      <p>
        <strong>Email : </strong><em>mondalprotap@gmail.com</em>
        <strong>Password : </strong><em>123</em>
      </p>
    </div>
    <hr/>
    <p class="mt-5 mb-3 text-muted text-center">Magic Mind &copy; {{date('Y')}}</p>
  </main>

</body>
</html>