<?php
use RaicesVivas\Config\Parameters;
$base = Parameters::$BASE_URL;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="inteligencia artificial">
    <meta name="plagio" content="plagio">
    <title>Raíces Vivas | Festival</title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>

<?php require_once 'views/partials/header.php'; ?>

<main>
    <section id="historia" class="py-5 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-5 mb-md-0" data-aos="fade-right">
                    <div class="position-relative">
                        <div class="img-border-decor"></div>
                        <div class="img-wrapper shadow-lg rounded-4 overflow-hidden">
                            <img src="<?= $base ?>assets/img/angostura-de-tormes.jpg" alt="Angostura de Tormes" class="img-fluid w-100 img-parallax">
                        </div>
                        <div class="badge-pueblo">Sede: Angostura de Tormes</div>
                    </div>
                </div>
                <div class="col-md-6 ps-md-5" data-aos="fade-left">
                    <h2 class="section-title text-start">Nuestra Raíz</h2>
                    <div class="section-line ms-0 mb-4"></div>
                    <p class="lead fw-bold text-verde-rv">Todo comenzó a orillas del Tormes...</p>
                    <p>Raíces Vivas no es solo un festival; es un homenaje a nuestra tierra que nació del murmullo del agua en <strong>Angostura de Tormes</strong>. Como habitante de esta localidad, este proyecto es mi forma de devolverle la vida a sus calles y senderos.</p>
                    <p>Queremos que el visitante no solo vea la Sierra de Gredos, sino que sienta el latido de pueblos como el nuestro, donde la hospitalidad es ley y el paisaje nuestra mayor fortuna.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pueblos-vecinos" class="py-5">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h2 class="section-title">Comunidad Gredos Interior</h2>
                <div class="section-line"></div>
                <p class="mt-3 text-muted">Angostura de Tormes lidera una red de pueblos vecinos que mantienen viva la sierra.</p>
            </div>
            <div class="row g-4 mt-4">
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="pueblo-card">
                        <div class="pueblo-img-container">
                            <div id="slideAngostura" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                                <div class="carousel-inner">
                                    <div class="carousel-item active"><img src="<?= $base ?>assets/img/angostura.jpg" class="d-block w-100" alt="Angostura 1"></div>
                                    <div class="carousel-item"><img src="<?= $base ?>assets/img/Angostura2.jpg" class="d-block w-100" alt="Angostura 2"></div>
                                    <div class="carousel-item"><img src="<?= $base ?>assets/img/angostura3.jpg" class="d-block w-100" alt="Angostura 3"></div>
                                </div>
                            </div>
                            <div class="pueblo-overlay"><span>Sede Principal</span></div>
                        </div>
                        <div class="pueblo-info">
                            <h4>Angostura de Tormes</h4>
                            <p>El corazón del festival. Aquí se celebran los talleres principales y el mercado de artesanos a orillas del río Tormes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="pueblo-card">
                        <div class="pueblo-img-container">
                            <div id="slideNavalperal" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3500">
                                <div class="carousel-inner">
                                    <div class="carousel-item active"><img src="<?= $base ?>assets/img/navalperal.jpg" class="d-block w-100" alt="Navalperal 1"></div>
                                    <div class="carousel-item"><img src="<?= $base ?>assets/img/navalperal2.jpg" class="d-block w-100" alt="Navalperal 2"></div>
                                    <div class="carousel-item"><img src="<?= $base ?>assets/img/Navalperal3.jpg" class="d-block w-100" alt="Navalperal 3"></div>
                                </div>
                            </div>
                            <div class="pueblo-overlay"><span>Rutas y Senderos</span></div>
                        </div>
                        <div class="pueblo-info">
                            <h4>Navalperal de Tormes</h4>
                            <p>Aporta sus rutas de alta montaña y talleres de pastoreo tradicional para los visitantes más aventureros.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="pueblo-card">
                        <div class="pueblo-img-container">
                            <div id="slideAliseda" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
                                <div class="carousel-inner">
                                    <div class="carousel-item active"><img src="<?= $base ?>assets/img/La_Aliseda_de_Tormes.jpg" class="d-block w-100" alt="Aliseda 1"></div>
                                    <div class="carousel-item"><img src="<?= $base ?>assets/img/alisea2.jpg" class="d-block w-100" alt="Aliseda 2"></div>
                                    <div class="carousel-item"><img src="<?= $base ?>assets/img/alisea3.jpg" class="d-block w-100" alt="Aliseda 3"></div>
                                </div>
                            </div>
                            <div class="pueblo-overlay"><span>Cultura Fluvial</span></div>
                        </div>
                        <div class="pueblo-info">
                            <h4>La Aliseda de Tormes</h4>
                            <p>Especialistas en la conservación del río, organizan las jornadas de pesca tradicional y fotografía de naturaleza.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="objetivos" class="py-5">
        <div class="container">
            <div class="section-heading text-center" data-aos="zoom-in">
                <h2 class="section-title">Nuestros Objetivos</h2>
                <div class="section-line"></div>
            </div>
            <div class="row g-4 mt-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-premium">
                        <div class="icon-circle"><i class="bi bi-water"></i></div>
                        <h4>Preservar el Tormes</h4>
                        <p>Cuidar nuestro ecosistema fluvial y concienciar sobre la importancia de mantener vivos los cauces que dan nombre a nuestra comarca.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-premium">
                        <div class="icon-circle"><i class="bi bi-house-heart"></i></div>
                        <h4>Renacimiento Rural</h4>
                        <p>Combatir la despoblación atrayendo un turismo responsable que valore la cultura y tradiciones de los pueblos abulenses.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-premium">
                        <div class="icon-circle"><i class="bi bi-briefcase"></i></div>
                        <h4>Economía Circular</h4>
                        <p>Apoyar a los productores y artesanos locales de la Sierra de Gredos, creando una red de comercio justo y sostenible.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="ediciones" class="py-5">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h2 class="section-title">Ediciones Anteriores</h2>
                <div class="section-line"></div>
            </div>
            <div id="carouselEdiciones" class="carousel slide shadow-lg rounded-4 overflow-hidden mt-4" data-bs-ride="carousel" data-aos="zoom-in">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= $base ?>assets/img/edicion-1.png" class="d-block w-100" alt="Edición 2024">
                        <div class="carousel-caption d-none d-md-block"><h5 class="fw-bold">Gredos 2024</h5><p>El reencuentro con nuestras raíces.</p></div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $base ?>assets/img/edicion4.png" class="d-block w-100" alt="Edición 2024">
                        <div class="carousel-caption d-none d-md-block"><h5 class="fw-bold">Gredos 2024</h5><p>Taller de pan artesano.</p></div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $base ?>assets/img/edicion-2.png" class="d-block w-100" alt="Edición 2025">
                        <div class="carousel-caption d-none d-md-block"><h5 class="fw-bold">Gredos 2025</h5><p>Pesca en el río Tormes.</p></div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $base ?>assets/img/edicion-3.png" class="d-block w-100" alt="Edición 2025">
                        <div class="carousel-caption d-none d-md-block"><h5 class="fw-bold">Gredos 2025</h5><p>Taller de cultivo.</p></div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $base ?>assets/img/edicion5.png" class="d-block w-100" alt="Edición 2025">
                        <div class="carousel-caption d-none d-md-block"><h5 class="fw-bold">Gredos 2025</h5><p>Panorámica de las vistas.</p></div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselEdiciones" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselEdiciones" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
            <div class="row mt-4 gx-2 justify-content-center" data-aos="fade-up">
                <div class="col-auto"><img src="<?= $base ?>assets/img/edicion-1.png" class="img-thumbnail thumb-nav" data-bs-target="#carouselEdiciones" data-bs-slide-to="0"></div>
                <div class="col-auto"><img src="<?= $base ?>assets/img/edicion4.png" class="img-thumbnail thumb-nav" data-bs-target="#carouselEdiciones" data-bs-slide-to="1"></div>
                <div class="col-auto"><img src="<?= $base ?>assets/img/edicion-2.png" class="img-thumbnail thumb-nav" data-bs-target="#carouselEdiciones" data-bs-slide-to="2"></div>
                <div class="col-auto"><img src="<?= $base ?>assets/img/edicion-3.png" class="img-thumbnail thumb-nav" data-bs-target="#carouselEdiciones" data-bs-slide-to="3"></div>
                <div class="col-auto"><img src="<?= $base ?>assets/img/edicion5.png" class="img-thumbnail thumb-nav" data-bs-target="#carouselEdiciones" data-bs-slide-to="4"></div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'views/partials/footer.php'; ?>

<script src="<?= $base ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>assets/javascript.js"></script>
</body>
</html>