<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="{{ asset('css/Login.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
  <img src="{{ asset('Images/CoffeeShop.png') }}" alt="Coffee Shop" 
       style="position: fixed; width: 100%; height: 100%; z-index: -1; filter: blur(3px); box-shadow: none;">
  
  <div class="container">
    <div class="image-section">
      <img src="{{ asset('Images/CoffeeCup.jpg') }}" alt="Coffee Cup" 
           style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div class="login-section"> 

      <h2>Admin Login</h2>

      {{-- Display success message --}}
      @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
      @endif

      {{-- Display error message --}}
      @if($errors->has('credentials'))
        <p style="color: red; font-weight: bold;">{{ $errors->first('credentials') }}</p>
      @endif

      <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        
        <p>Username:</p>
        <input type="text" name="username" placeholder="Admin" value="{{ old('username') }}" required>
        @error('username')
          <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror

        <p>Password:</p>
        <input type="password" name="password" placeholder="Password" required>
        @error('password')
          <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror

        <div class="button-group">
          <button type="submit">Login</button>
        </div>
      </form>

      <div class="register-link">
        <a href="{{ url()->previous() }}" class="back-btn">Back</a>
      </div>
    </div>
  </div>
</body>
</html>