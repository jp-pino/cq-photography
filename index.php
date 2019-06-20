<?php
require_once("modelo.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans:400,300,700|Quicksand|Roboto" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/theme.css" rel="stylesheet">
        <link href="css/gallery.css" rel="stylesheet">
        <link href="css/full-slider.css" rel="stylesheet">
        <link href="css/menu.css" rel="stylesheet">
        <link href="css/Footer-with-button-logo.css" rel="stylesheet">


        <title>Cris Quintanilla</title>
    </head>
    <body>
        <div id="carousel-top" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <?php getCarouselIndicators(); ?>
            </ol>
            <div class="carousel-inner" role="listbox">
                <!-- Slide One - Set the background image for this slide in the line below -->
                <?php getCarousel(); ?>
            </div>
            <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a> -->
        </div>
        <div class="carousel-main">
            <img src="images/logo_white.png" width="200" height="200"/>
        </div>

        <nav id="main-nav" class="navbar navbar-expand-lg navbar-dark bg-black sticky-top" style="z-index: 3002;">
            <a class="navbar-brand mr-auto" href="index.php"><div class="title-text">Cris Quintanilla <span class="d-none d-sm-inline">Photography</span></div></a>

            <div class="burger">
                <div class="burger__patty"></div>
                <div class="burger__patty"></div>
                <div class="burger__patty"></div>
            </div>
        </nav>

        <nav class="menu" style="z-index: 3001;">
            <div class="menu__brand">
                <a href="">
                    <div class="logo">
                        <img src="images/logo_white.png"/>
                    </div>
                </a>
            </div>
            <ul class="menu__list">
                <li class="menu__item"><a href="index.php" class="menu__link">Inicio</a></li>
                <li class="menu__item"><a href="index.php?#content" class="menu__link">Galería</a></li>
                <li class="menu__item"><a href="about.php" class="menu__link">Sobre mí</a></li>
                <li class="menu__item mt-4">
                    <a href="https://www.instagram.com/crisquintanillac.ph/" class="px-2 text-white"><i class="fab fa-2x fa-instagram"></i></a>
                    <a href="https://www.facebook.com/photography.cqc/" class="px-2 text-white"><i class="fab fa-2x fa-facebook"></i></a>
                    <a href="mailto:crisquintanillac@gmail.com?Subject=Informacion" target="_top" class="px-2 text-white"><i class="fas fa-2x fa-envelope"></i></a>
                </li>
            </ul>

        </nav>

        <main id="content" class="container pt-4 mt-4">
            <ul class="collection-list">
            	<?php getCollections(); ?>
            </ul>
        </main>

        <div id="particles-js"></div>

        <footer id="myFooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="container-fluid mr-5">
                                <div class="footer-logo">
                                    <h2 class="logo"><img src="images/logo_white.png" class="img img-fluid"/></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="container mt-4">
                            <div class="social-networks d-none d-md-block pb-1 mb-1">
                                <a href="https://www.instagram.com/crisquintanillac.ph/" class="instagram"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.facebook.com/photography.cqc/" class="facebook"><i class="fab fa-facebook-square"></i></a>
                                <a href="mailto:crisquintanillac@gmail.com?Subject=Informacion" class="mail"><i class="fas fa-envelope"></i></a>
                            </div>
                            <p class="pt-1"><a href="tel:+52 (442) 123 2824">+52 (442) 123 2824</a></p>
                            <div class="social-networks d-md-none">
                                <a href="https://www.instagram.com/crisquintanillac.ph/" class="instagram"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.facebook.com/photography.cqc/" class="facebook"><i class="fab fa-facebook-square"></i></a>
                                <a href="mailto:crisquintanillac@gmail.com?Subject=Informacion" class="mail"><i class="fas fa-envelope"></i></a>
                            </div>
                            <div class="row">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal">Contáctanos</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
            <div class="footer-copyright">
                <p>© 2018 Cris Quintanilla </p>
            </div>
        </footer>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 4000;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Contáctame!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">

                        <form id="contact-form" method="post" action="contact.php" role="form">

                            <div class="messages"></div>

                            <div class="controls">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_name">Nombre *</label>
                                            <input id="form_name" type="text" name="name" class="form-control" placeholder="Pedro" required="required" data-error="El nombre es requerido.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_lastname">Apellido *</label>
                                            <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Pérez" required="required" data-error="El apellido es requerido.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_email">Email *</label>
                                            <input id="form_email" type="email" name="email" class="form-control" placeholder="nombre@mail.com" required="required" data-error="El email es requerido.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_phone">Teléfono</label>
                                            <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="4420000000">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_message">Mensaje *</label>
                                            <textarea id="form_message" name="message" class="form-control" placeholder="Quisiera información sobre..." rows="4" required="required" data-error="Por favor deje un mensaje breve con su consulta."></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-success btn-send" value="Enviar">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-muted"><strong>*</strong> Estos campos son requeridos.</p>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="js/vh-check.min.js"></script>
        <script>
            (function () {
                // initialize the test
                var isNeeded = vhCheck('ios-gap');
            }());

            $(".carousel-item").eq(0).addClass("active");
        </script>
        <script src="js/lazyLoad.js"></script>
        <script src="js/fade-title.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.js"></script>
        <script src="js/app.js"></script>
        <script src="js/menu.js"></script>
        <!-- <script src="js/nav.js"></script> -->
    </body>

</html>
