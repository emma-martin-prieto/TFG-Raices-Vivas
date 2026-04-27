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
    <title>Raíces Vivas | Festival de Renacimiento Rural</title>

    <link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = {
            corePlugins: { preflight: false },
            theme: { extend: { colors: { 'verde-rv': '#237c4a', 'naranja-rv': '#E38D2D', 'crema-rv': '#FDFBF7' } } }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<?php require_once 'views/layout/header.php'; ?>

<main>
    <!-- HERO -->
    <section class="hero-section">
        <video autoplay loop muted playsinline class="hero-video">
            <source src="<?= $base ?>assets/Sierra de Gredos _ a vista dron.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="container hero-content text-center text-white">
            <h1 class="display-3 fw-bold mb-3">Tu próxima vida empieza aquí</h1>
            <p class="lead mb-4 fst-italic">"Vive el pueblo, no solo lo visites"</p>
            <a href="<?= $base ?>Actividad/showExperiencias"
               class="btn btn-naranja btn-lg rounded-pill px-5 py-3">
                Quiero participar
            </a>
        </div>
    </section>

    <!-- EXPLORA LA SIERRA -->
    <section class="py-20 container" id="exploralasierra">
        <div class="section-heading text-center" data-aos="fade-up">
            <h2 class="section-title">Explora la Sierra de Gredos</h2>
            <div class="section-line"></div>
        </div>
        <div class="row g-4 items-center" data-aos="zoom-in">
            <div class="col-lg-8">
                <div class="ratio ratio-16x9 rounded-3xl overflow-hidden shadow-2xl">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3521.936253711068!2d-5.351997681843243!3d40.33675352299633!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd3f97770d3adf99%3A0x443c4b1c80a883a4!2s05631%20Angostura%20de%20Tormes%2C%20%C3%81vila!5e1!3m2!1ses!2ses!4v1774133761184!5m2!1ses!2ses"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 bg-white rounded-2xl shadow-sm">
                    <h3 class="h5 fw-bold mb-3">Puntos de Interés</h3>
                    <p class="text-muted small mb-4">Haz clic en los marcadores para ver las actividades programadas.</p>
                    <button type="button" class="btn btn-outline-dark w-100 mb-3"
                            data-bs-toggle="popover"
                            title="Transporte Público"
                            data-bs-content="Existen autobuses diarios desde Madrid (Estación Sur) y Ávila hasta El Barco de Ávila y Hoyos del Espino.">
                        ¿Cómo llegar?
                    </button>
                    <div class="d-flex align-items-center gap-3 p-3 border rounded-xl">
                        <div class="spinner-border text-success spinner-border-sm" role="status"></div>
                        <span class="small font-semibold italic text-verde-rv">Cargando disponibilidad en tiempo real...</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GREDOS EN CIFRAS -->
    <section class="cifras-section text-center" id="gredosencifras">
        <div class="container">
            <div class="section-heading" data-aos="fade-up">
                <h2 class="section-title">Gredos en cifras</h2>
                <div class="section-line"></div>
            </div>
            <div id="cifras-loading" class="mb-5" data-aos="zoom-in">
                <div class="spinner-border text-success" role="status"></div>
                <p class="mt-3 text-muted">Cargando datos...</p>
            </div>
            <div id="cifras-content" class="row justify-content-center g-4 d-none">
                <div class="col-md-4">
                    <div class="cifra-circle"><h3>+50</h3><p>Nuevos habitantes</p></div>
                </div>
                <div class="col-md-4">
                    <div class="cifra-circle"><h3>+500</h3><p>Participantes</p></div>
                </div>
                <div class="col-md-4">
                    <div class="cifra-circle"><h3>+35</h3><p>Actividades</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h2 class="section-title">Preguntas frecuentes</h2>
                <div class="section-line"></div>
            </div>
            <div class="accordion" id="faqAccordion" data-aos="zoom-in">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            ¿Cuándo es el próximo festival?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            El próximo festival será del 12 al 14 de junio de 2026 en diversos pueblos de la Sierra de Gredos.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            ¿Qué incluye la inscripción?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Acceso a talleres, rutas guiadas, charlas y la posibilidad de reservar alojamiento rural. Cada actividad tiene su precio indicado.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            ¿Puedo ir con niños?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            ¡Por supuesto! Tenemos actividades para familias como la Senda del Río Tormes o los Juegos Tradicionales, aptas para todos los públicos.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            ¿Cuánto cuestan las actividades?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Los precios van desde 5€ las charlas hasta 28€ las rutas de alta montaña. Puedes ver todos los precios en la sección Experiencias.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            ¿Qué pasa si se cancela el festival?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Si el festival se cancela, recibirás un correo electrónico con la explicación y las instrucciones para la devolución del importe.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'views/layout/footer.php'; ?>

<script src="<?= $base ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>assets/javascript.js"></script>
</body>
</html>