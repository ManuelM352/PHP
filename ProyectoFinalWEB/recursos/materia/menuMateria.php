
<nav class="navbar navbar-expand-lg" style="background-color: #00A13A;" data-bs-theme="dark">
  <div class="container-fluid">
    <nav class="navbar">
      <div class="container-nav" style="background-color: #00A13A;">
        <img src="../src/SICE Clon Recortado.png" alt="Bootstrap" width="150px" height="35" role="img">
        </a>
      </div>
    </nav>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">

        </li>
        <li class="nav-item">

        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../usuarios/tablaUsuario.php">Usuarios</a>
        </li>
      </ul>
    </div>
  </div>
  <ul class="navbar-nav mb-2 mb-lg-0" style="margin-right: 60px;">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?=ISSET($_SESSION["nombre"])?$_SESSION["nombre"]:""?>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="../cerrarSesion.php">Cerrar Sesión</a></li>
                </ul>
              </li>
        </ul>
  <!-- <div style="display: flex;">
    <p>Usuario actual: <?= isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?></p>
    <div class="user">
      <button class="Btn dropdown-item" onclick="location.href='../cerrarSesion.php'">
        <div class="sign"><svg viewBox="0 0 512 512">
            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
          </svg></div>
        <div class="text">Logout</div>
      </button>
    </div>
  </div> -->
</nav>