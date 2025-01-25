<?php
include 'header.php';
// Database connection
include 'db_connection.php';

// Fetch upcoming events
$sql = "SELECT * FROM events WHERE status = 'upcoming' ORDER BY event_date ASC";
$result = $conn->query($sql);
?>
<style>
    #accordion:before {
        content: "";
        width: 1px;
        height: 80%;
        background: #6c838f;
        position: absolute;
        top: 20px;
        left: 24px;
        bottom: 20px;
    }

    #accordion .panel {
        border: none;
        border-radius: 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        margin: 0 0 12px 50px;
        position: relative;
    }

    #accordion .panel:before {
        content: "";
        width: 2px;
        height: 100%;
        background: linear-gradient(to bottom, #688e26 0%, #ff816a 100%);
        position: absolute;
        top: 0;
        left: -2px;
    }

    #accordion .panel-heading {
        padding: 0;
        background: #fff;
        position: relative;
    }

    #accordion .panel-heading:before {
        content: "";
        width: 15px;
        height: 15px;
        border-radius: 50px;
        background: #fff;
        border: 1px solid #6c838f;
        position: absolute;
        top: 50%;
        left: -48px;
        transform: translateY(-50%);
    }

    #accordion .panel-title a {
        display: block;
        padding: 15px 55px 15px 30px;
        font-size: 20px;
        font-weight: 600;
        color: #6c838f;
        margin: 0;
        position: relative;
    }

    #accordion .panel-title a:before,
    #accordion .panel-title a.collapsed:before {
        content: "\f068";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        width: 25px;
        height: 25px;
        line-height: 25px;
        border-radius: 50%;
        font-size: 15px;
        font-weight: normal;
        color: #688e26;
        text-align: center;
        border: 1px solid #688e26;
        position: absolute;
        top: 50%;
        right: 25px;
        transform: translateY(-50%);
        transition: all 0.5s ease 0s;
    }

    #accordion .panel-title a.collapsed:before {
        content: "\f067";
    }

    #accordion .panel-body {
        padding: 0 30px 15px;
        border: none;
        font-size: 14px;
        color: #305275;
        line-height: 28px;
    }
</style>
<section class="hero">
    <div class="home-slider owl-carousel js-fullheight">
        <div class="slider-item js-fullheight" style="background-image:url(images/hero/1.webp);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                    <div class="col-md-12 ftco-animate">
                        <div class="text w-100 text-center">
                            <h2>Best Society to Learn</h2>
                            <h1 class="mb-3">SENTEC</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-item js-fullheight" style="background-image:url(images/hero/2.webp);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                    <div class="col-md-12 ftco-animate">
                        <div class="text w-100 text-center">
                            <h2>Best Society to Connect</h2>
                            <h1 class="mb-3">MPERC</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-item js-fullheight" style="background-image:url(images/hero/3.webp);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                    <div class="col-md-12 ftco-animate">
                        <div class="text w-100 text-center">
                            <h2>Best Society to Enjoy</h2>
                            <h1 class="mb-3">OLYMPIAD</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="text-center">
    <hr class="hr-text" data-content="">
</section>
<!-- About-->
<section class="py-5" id="about">
    <div class="container">
        <div class="row align-items-center gx-4">
            <div class="col-md-5">
                <div class="ms-md-2 ms-lg-5"><img class="img-fluid rounded-3" src="./sentec logo without bg.png"></div>
            </div>
            <div class="col-md-6 offset-md-1">
                <div class="ms-md-2 ms-lg-5">
                    <span class="text-muted">Our Story</span>
                    <h2 class="display-5 fw-bold">About Us</h2>
                    <p class="lead">The Society for Promotion of Science Engineering and Technology which also goes by the name SENTEC is one of the most esteemed societies of NED University of Engineering and technology. It has the privilege of being the only official society of the university which has been actively functioning for the past 20 years. The society aims to impart the students with exposure to the practical implementation of their courses. Throughout the years it has proved to not only provide a platform to students to showcase their talents but has encouraged the participants to hone their technical skills as well.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="text-center">
    <hr class="hr-text" data-content="">
</section>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center text-center mb-4 mb-md-5">
            <div class="col-xl-9 col-xxl-8">
                <span class="text-muted">Upcoming Events</span>
                <h2 class="display-5 fw-bold">Our Upcoming Events</h2>
                <p class="lead">Stay tuned for our latest events and news. We have exciting programs coming your way!</p>
            </div>
        </div>

        <?php
        if ($result->num_rows > 0) {
            // Loop through the events and display them
            while ($row = $result->fetch_assoc()) {
                $event_title = $row['title'];
                $event_date = date('d.m.Y', strtotime($row['event_date']));
                $event_description = $row['description'];
                $event_category = $row['category'];
                $event_imagereplace = $row['image_url'];
                $event_image = str_replace('../', './', $event_imagereplace);
        ?>
                <div class="row g-0 align-items-center mb-5">
                    <div class="col-md-6">
                        <img alt="<?php echo htmlspecialchars($event_title); ?>" class="img-fluid" src="<?php echo htmlspecialchars($event_image); ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-12 col-xxl-10 col-xl-12">
                                <div class="p-md-3 p-xl-5 mt-4 mt-md-0">
                                    <a class="text-primary fw-semibold text-decoration-none" href="#"><?php echo htmlspecialchars($event_category); ?></a>
                                    <h2 class="fw-semibold my-1"><?php echo htmlspecialchars($event_title); ?></h2>
                                    <div class="text-muted"><?php echo htmlspecialchars($event_date); ?></div>
                                    <p class="my-4"><?php echo nl2br(htmlspecialchars($event_description)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p class='text-center'>No upcoming events found.</p>";
        }
        ?>

    </div>
</section>
<section class="text-center">
    <hr class="hr-text" data-content="">
</section>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center text-center mb-2 mb-lg-4">
            <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto">
                <!-- <span class="text-muted">Raving Fans</span> -->
                <h2 class="display-5 fw-bold">Our Faculty Incharge</h2>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta harum ipsum venenatis metus sem veniam eveniet aperiam suscipit.</p>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-md-5 order-2 order-md-1">
                <div class="mb-4" style="color: #6c838f;">
                    <svg class="bi bi-quote" fill="currentColor" height="48" viewbox="0 0 16 16" width="48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z"></path>
                    </svg>
                </div>
                <p>A good balance between academics and activities is crucial. SENTEC can be a great platform for students to develop their capabilities as engineering graduates.</p>
                <h5 class="fw-bold">DR. Murtuza Mehdi</h5>
                <div class="text-muted">
                    Faculty Incharge SENTEC
                </div>
            </div>
            <div class="col-md-6 order-1 order-md-2">
                <div class="mb-4 mb-md-0"><img class="img-fluid" src="./images/facinc.png"></div>
            </div>
        </div>
    </div>
</section>
<section class="text-center">
    <hr class="hr-text" data-content="">
</section>
<section class="py-5" id="faq">
    <div class="container">
        <div class="row justify-content-center text-center mb-3">
            <div class="col-lg-8 col-xl-7">
                <span class="text-muted">F.A.Q</span>
                <h2 class="display-5 fw-bold">Frequently Asked Questions</h2>
                <p class="lead">Lorem ipsum dolor sit, amet consectetur adipisicing elit Consequatur quidem eius cum voluptatum quasi delectus.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <span class="text-muted">Lorem ipsum dolor</span>
                <h2 class="pb-4 fw-bold">Have Any Questions?</h2>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur quidem eius cum voluptatum quasi delectus assumenda culpa.</p><a class="btn btn-lg text-white mt-3" style="background-color: #6c838f;" href="#">Contact us</a>
            </div>
            <div class="col-md-7">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                    Section 1
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisl lorem, dictum id pellentesque at, vestibulum ut arcu. Curabitur erat libero, egestas eu tincidunt ac, rutrum ac justo. Vivamus condimentum laoreet lectus, blandit posuere tortor aliquam vitae. Curabitur molestie eros. </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Section 2
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisl lorem, dictum id pellentesque at, vestibulum ut arcu. Curabitur erat libero, egestas eu tincidunt ac, rutrum ac justo. Vivamus condimentum laoreet lectus, blandit posuere tortor aliquam vitae. Curabitur molestie eros. </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Section 3
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisl lorem, dictum id pellentesque at, vestibulum ut arcu. Curabitur erat libero, egestas eu tincidunt ac, rutrum ac justo. Vivamus condimentum laoreet lectus, blandit posuere tortor aliquam vitae. Curabitur molestie eros. </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Section 4
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisl lorem, dictum id pellentesque at, vestibulum ut arcu. Curabitur erat libero, egestas eu tincidunt ac, rutrum ac justo. Vivamus condimentum laoreet lectus, blandit posuere tortor aliquam vitae. Curabitur molestie eros. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$conn->close();
include 'footer.php';
?>