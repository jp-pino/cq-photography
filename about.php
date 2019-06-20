<?php require_once("modelo.php"); ?>
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

        <!-- Custom CSS -->
        <link href="css/theme.css" rel="stylesheet">
        <link href="css/gallery.css" rel="stylesheet">
        <link href="css/menu.css" rel="stylesheet">
        <link href="css/Footer-with-button-logo.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Quicksand|Roboto" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">

        <title>Cris Quintanilla</title>
    </head>
    <body>
        <nav id="main-nav" class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
            <a class="navbar-brand mr-auto" href="index.php"><div class="title-text">Cris Quintanilla <span class="d-none d-sm-inline">Photography</span></div></a>
            <div class="burger">
                <div class="burger__patty"></div>
                <div class="burger__patty"></div>
                <div class="burger__patty"></div>
            </div>
        </nav>

        <nav class="menu">
            <div class="menu__brand">
                <a href="">
                    <div class="logo">
                        <img src="images/logo.png"/>
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
                    <a href="mailto:crisquintanillac@gmail.com?Subject=Informacion" class="px-2 text-white"><i class="fas fa-2x fa-envelope"></i></a>
                </li>
            </ul>
        </nav>

        <div class="photo-background" style="<?php echo getBackgroundImage(); ?>"></div>
        <div id="about" class="container rounded shadow cn">
            <?php echo getQuotes(); ?>


            <!-- <h2>Cris Quintanilla</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> -->
        </div>


        <div id="about2" class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="container pb-5">
                        <img class="img img-fluid" src="<?php echo getBioPic(); ?>">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="container-fluid">
                        <h2>Cris Quintanilla</h2>
                        <p class="lead"><?php echo getBio(); ?></p>
                    </div>
                </div>
            </div>
        </div>

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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <script src="js/menu.js"></script>
        <script src="js/quote-slider.js"></script>
        <script>
            $("#main-nav").css("opacity", 0.875);
            $(".title-text").css("opacity", 1);
            $(".burger").css("opacity", 1);
        </script>
    </body>

</html>
