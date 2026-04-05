<?php
use RaicesVivas\Config\Parameters;
$base = Parameters::$BASE_URL;
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3"
               href="<?= $base ?>index.php">
                <img src="<?= $base ?>assets/img/logo.png" alt="Logo Raíces Vivas" class="rv-logo">
                <span class="fw-bold text-verde-rv rv-brand-text">RAÍCES VIVAS</span>
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navMain"
                    aria-controls="navMain" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav mx-auto gap-lg-4 mt-3 mt-lg-0 align-items-lg-center">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold"
                           href="<?= $base ?>index.php"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Inicio
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg">
                            <li><a class="dropdown-item" href="<?= $base ?>index.php#exploralasierra">Explora la Sierra</a></li>
                            <li><a class="dropdown-item" href="<?= $base ?>index.php#gredosencifras">Gredos en Cifras</a></li>
                            <li><a class="dropdown-item" href="<?= $base ?>index.php#faq">Preguntas Frecuentes</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold"
                           href="<?= $base ?>index.php?controller=Festival&action=showFestival"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Festival
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg">
                            <li><a class="dropdown-item" href="<?= $base ?>index.php?controller=Festival&action=showFestival#historia">Historia</a></li>
                            <li><a class="dropdown-item" href="<?= $base ?>index.php?controller=Festival&action=showFestival#pueblos-vecinos">Comunidad Gredos Interior</a></li>
                            <li><a class="dropdown-item" href="<?= $base ?>index.php?controller=Festival&action=showFestival#objetivos">Objetivos</a></li>
                            <li><a class="dropdown-item" href="<?= $base ?>index.php?controller=Festival&action=showFestival#ediciones">Ediciones anteriores</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold"
                           href="<?= $base ?>index.php?controller=Actividad&action=showExperiencias">
                            Experiencias
                        </a>
                    </li>

                </ul>
                <div class="d-flex">
                    <a class="btn btn-naranja rounded-pill px-4"
                       href="<?= $base ?>index.php?controller=Inscripcion&action=showFormulario">
                        Inscríbete
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>