<?php use RaicesVivas\Config\Parameters; $base = Parameters::$BASE_URL; ?>
<footer class="footer-tablon py-5" id="AI">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center align-items-start">

            <div class="col" data-aos="fade-up">
                <div class="nota-papel nota-marca text-center">
                    <div class="chincheta"></div>
                    <img src="<?= $base ?>assets/img/logo.png" alt="Festival Raíces Vivas" class="footer-logo mb-3">
                    <p class="small text-muted manifiesto">
                        Un festival dedicado al renacimiento rural y la cultura sostenible en el corazón de la Sierra de Gredos.
                    </p>
                </div>
            </div>

            <div class="col" data-aos="fade-up" data-aos-delay="100">
                <div class="nota-papel nota-1">
                    <div class="chincheta verde"></div>
                    <span class="nota-categoria text-uppercase">Mapa del sitio</span>
                    <nav class="nav-vertical">
                        <a href="<?= $base ?>">Inicio</a>
                        <a href="<?= $base ?>festival.html">El Festival</a>
                        <a href="<?= $base ?>Actividad/showExperiencias">Experiencias</a>
                        <a href="<?= $base ?>Inscripcion/showFormulario">Inscripciones</a>
                    </nav>
                </div>
            </div>

            <div class="col" data-aos="fade-up" data-aos-delay="150">
                <div class="nota-papel nota-social">
                    <div class="chincheta naranja"></div>
                    <span class="nota-categoria text-uppercase">Momentos #Gredos</span>
                    <nav class="nav-vertical">
                        <a href="https://www.instagram.com/"><i class="bi bi-instagram me-2"></i> Instagram</a>
                        <a href="https://www.tiktok.com/"><i class="bi bi-tiktok me-2"></i> TikTok</a>
                        <a href="https://www.facebook.com/"><i class="bi bi-facebook me-2"></i> Facebook</a>
                        <a href="https://www.youtube.com/"><i class="bi bi-youtube me-2"></i> YouTube</a>
                        <a href="https://x.com/"><i class="bi bi-twitter-x me-2"></i> Twitter</a>
                    </nav>
                </div>
            </div>

            <div class="col" data-aos="fade-up" data-aos-delay="200">
                <div class="nota-papel nota-legal">
                    <div class="chincheta azul"></div>
                    <span class="nota-categoria text-uppercase">Legal y Cookies</span>
                    <nav class="nav-vertical">
                        <a href="#">Aviso Legal</a>
                        <a href="#">Privacidad</a>
                        <a href="#">Cookies</a>
                    </nav>
                </div>
            </div>

            <div class="col" data-aos="fade-up" data-aos-delay="300">
                <div class="nota-papel nota-contacto">
                    <div class="chincheta roja"></div>
                    <span class="nota-categoria text-uppercase">¿Alguna duda?</span>
                    <div class="contacto-info-mejorado">
                        <p class="d-flex align-items-center mb-3">
                            <i class="bi bi-geo-alt-fill text-naranja-rv me-2"></i>
                            <a href="https://maps.app.goo.gl/kdsCFnjYF3v8SdeM9"
                               class="small fw-bold text-decoration-none text-reset">Sierra de Gredos</a>
                        </p>
                        <p class="d-flex align-items-center mb-3">
                            <i class="bi bi-envelope-at-fill text-naranja-rv me-2"></i>
                            <a href="mailto:hola@raicesvivas.es"
                               class="small fw-bold text-decoration-none text-reset">hola@raicesvivas.es</a>
                        </p>
                        <p class="d-flex align-items-center">
                            <i class="bi bi-whatsapp text-naranja-rv me-2"></i>
                            <a href="https://wa.me/34920123456"
                               class="small fw-bold text-decoration-none text-reset">+34 920 123 456</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-center mt-5 pt-4 border-top border-secondary opacity-50">
            <p class="small mb-0">&copy; 2026 Raíces Vivas.</p>
        </div>
    </div>
</footer>
