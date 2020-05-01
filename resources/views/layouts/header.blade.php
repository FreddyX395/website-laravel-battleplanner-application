<style>
  .btn-primary{
    font-size: 16px;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Rainbow Six Battleplanner</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample05">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/battleplan">Public Plans</a>
            </li>

            @auth
            <li class="nav-item">
                <a class="nav-link" href="/room">Rooms</a>
            </li>
            @endauth
        </ul>


        <ul class="navbar-nav ml-auto">
          @guest
          <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
          </li>

          <li class="nav-item">
              <a class="nav-link btn btn-primary btn-xl" href="/register">Register</a>
          </li>
          @endguest

          @auth
            @admin
            <li class="nav-item">
                <a class="nav-link" href="/admin">Admin</a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="/account">Account</a>
            </li>

            <li class="nav-item">
              <a class="nav-link btn btn-primary" onclick='logout()'>Logout</a>
            </li>
          @endauth
        </ul>

    </div>
</nav>


@push('js')
  <script type="text/javascript">
    function logout(){
      $.ajax({
        method: "POST",
        url: "/logout"
      })
      .done(function( msg ) {
        window.location.href = "/";
      });
    }
  </script>

@endpush
