<?php
include "./dbconnection.php";
$drinks = $conn->query("SELECT * from drink_menu");
$drink_data = $drinks->fetchAll();
/////////////////////////////////////////////////////////////////////////////////////
$category = $conn->query("SELECT * from categories");
$category_data = $category->fetchAll();
/////////////////////////////////////////////////////////////////////////////////////
$reversed_categories = array_reverse($category_data);
/////////////////////////////////////////////////////////////////////////////////////
$special = $conn->query("SELECT * from special");
$special_data = $special->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wave Cafe</title>
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" />
  <link rel="stylesheet" href="css/tooplate-wave-cafe.css">
</head>

<body>
  <div class="tm-container">
    <div class="tm-row">
      <!-- Site Header -->
      <div class="tm-left">
        <div class="tm-left-inner">
          <div class="tm-site-header">
            <i class="fas fa-coffee fa-3x tm-site-logo"></i>
            <h1 class="tm-site-name">Wave Cafe</h1>
          </div>
          <nav class="tm-site-nav">
            <ul class="tm-site-nav-ul">
              <li class="tm-page-nav-item">
                <a href="#drink" class="tm-page-link active">
                  <i class="fas fa-mug-hot tm-page-link-icon"></i>
                  <span>Drink Menu</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="#about" class="tm-page-link">
                  <i class="fas fa-users tm-page-link-icon"></i>
                  <span>About Us</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="#special" class="tm-page-link">
                  <i class="fas fa-glass-martini tm-page-link-icon"></i>
                  <span>Special Items</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="#contact" class="tm-page-link">
                  <i class="fas fa-comments tm-page-link-icon"></i>
                  <span>Contact</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="tm-right">
        <main class="tm-main">
          <div id="drink" class="tm-page-content">
            <!-- Drink Menu Page -->
            <nav class="tm-black-bg tm-drinks-nav">
              <ul>
                <?php
                $firstCategory = true;
                foreach ($reversed_categories as $category) {
                  $activeClass = $firstCategory ? 'active' : '';
                  echo "<li>
                  <a href='#' class='tm-tab-link $activeClass' data-id='{$category['category_name']}'> {$category['category_name']} </a>
                </li>";
                  $firstCategory = false;
                }
                ?>
              </ul>
            </nav>

            <?php
            foreach ($reversed_categories as $category) {
              echo "<div id='{$category['category_name']}' class='tm-tab-content'>";
              echo "<div class='tm-list'>";
              foreach ($drink_data as $drink) {
                if ($drink['category_name'] === $category['category_name']) {
                  $img = base64_encode($drink['drink_img']);
                  $price = $drink['drink_price'];
                  $formatted_price = number_format($price, 2, '.', '');
                  $formatted_price = "$" . (string) $formatted_price;
                  echo " <div class='tm-list-item'>          
                                  <img src='data:image/png;charset=utf8;base64,{$img}' class='tm-list-item-img'>
                                  <div class='tm-black-bg tm-list-item-text'>
                                    <h3 class='tm-list-item-name'>{$drink['drink_name']}<span class='tm-list-item-price'>{$formatted_price}</span></h3>
                                    <p class='tm-list-item-description'>{$drink['drink_description']}</p>
                                  </div>
                                </div>";
                }

              }
              echo "</div>";
              echo "</div>";
            }
            ?>
            <!-- end Drink Menu Page -->
          </div>

          <!-- About Us Page -->
          <div id="about" class="tm-page-content">
            <div class="tm-black-bg tm-mb-20 tm-about-box-2">
              <h2 class="tm-text-primary tm-about-header">About Wave Cafe</h2>
              <div class="tm-list-item tm-list-item-2">
                <div>
                  <img src="img/about-1.png" alt="Image" class="tm-list-item-img tm-list-item-img-big">
                </div>

                <div class="tm-list-item-text-2">
                  <p>Wave Cafe is a charming
                    and cozy coffee shop nestled in the heart of Anytown.
                    Our cafe is not just a place to grab your daily caffeine fix;
                    it's a warm and welcoming haven for coffee enthusiasts, friends, families, and remote workers
                    looking for a comfortable and inviting space.</p>
                </div>
              </div>
            </div>


            <div class="tm-black-bg tm-mb-20 tm-about-box-2">
              <div class="tm-list-item tm-list-item-2">
                <div class="tm-list-item-text-2">
                  <h2 class="tm-text-primary">How we began</h2>
                  <p>Wave Cafe's journey began with two close friends, who shared a deep
                    love for coffee and a dream of creating a unique gathering place in their hometown, Anytown. Both
                    had spent years working in different coffee shops, developing a strong appreciation for the art of
                    coffee-making and the warm connections that coffee shops could foster.</p>
                </div>
                <img src="img/about-2.png" alt="Image" class="tm-list-item-img tm-list-item-img-big tm-img-right">
              </div>
            </div>
          </div>
          <!-- end About Us Page -->

          <!-- Special Items Page -->
          <div id="special" class="tm-page-content">
            <div class="tm-special-items">
              <?php
              foreach($special_data as $special){
                $img2 = base64_encode($special['special_img']);
                echo "<div class='tm-black-bg tm-special-item'>
                <img src='data:image/png;charset=utf8;base64,{$img2}'>
                <div class='tm-special-item-description'>
                  <h2 class='tm-text-primary tm-special-item-title'>{$special['special_name']}</h2>
                  <p class='tm-special-item-text'>{$special['special_description']}</p>
                </div>
              </div>";
              } ?>
            </div>
          </div>
          <!-- end Special Items Page -->

          <!-- Contact Page -->
          <div id="contact" class="tm-page-content">
            <div class="tm-black-bg tm-contact-text-container">
              <h2 class="tm-text-primary">Contact Wave</h2>
              <p>Wave Cafe'd love to hear from you! Send us a message, and we'll get back to you as soon as possible.
              </p>
            </div>
            <div class="tm-black-bg tm-contact-form-container tm-align-right">
              <form action="" method="POST" id="contact-form">
                <div class="tm-form-group">
                  <input type="text" name="name" class="tm-form-control" placeholder="Name" required="" />
                </div>
                <div class="tm-form-group">
                  <input type="email" name="email" class="tm-form-control" placeholder="Email" required="" />
                </div>
                <div class="tm-form-group tm-mb-30">
                  <textarea rows="6" name="message" class="tm-form-control" placeholder="Message"
                    required=""></textarea>
                </div>
                <div>
                  <button type="submit" class="tm-btn-primary tm-align-right">
                    Submit
                  </button>
                </div>
              </form>
            </div>
          </div>
          <!-- end Contact Page -->
        </main>
      </div>
    </div>
    <footer class="tm-site-footer">
      <p class="tm-black-bg tm-footer-text"> © Wave Cafe 2023 | All rights reserved </p>
    </footer>
  </div>

  <!-- Background video -->
  <div class="tm-video-wrapper">
    <i id="tm-video-control-button" class="fas fa-pause"></i>
    <video autoplay muted loop id="tm-video">
      <source src="video/wave-cafe-video-bg.mp4" type="video/mp4">
    </video>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script>

    function setVideoSize() {
      const vidWidth = 1920;
      const vidHeight = 1080;
      const windowWidth = window.innerWidth;
      const windowHeight = window.innerHeight;
      const tempVidWidth = windowHeight * vidWidth / vidHeight;
      const tempVidHeight = windowWidth * vidHeight / vidWidth;
      const newVidWidth = tempVidWidth > windowWidth ? tempVidWidth : windowWidth;
      const newVidHeight = tempVidHeight > windowHeight ? tempVidHeight : windowHeight;
      const tmVideo = $('#tm-video');

      tmVideo.css('width', newVidWidth);
      tmVideo.css('height', newVidHeight);
    }

    document.addEventListener("DOMContentLoaded", function () {
      var tabLinks = document.querySelectorAll('.tm-tab-link');
      var tabContents = document.querySelectorAll('.tm-tab-content');

      tabContents.forEach(function (content) {
        content.style.display = 'none';
      });

      tabLinks.forEach(function (tabLink) {
        tabLink.addEventListener('click', function (event) {
          event.preventDefault();

          tabLinks.forEach(function (link) {
            link.classList.remove('active');
          });

          tabLink.classList.add('active');

          tabContents.forEach(function (content) {
            content.style.display = 'none';
          });

          var targetTab = document.getElementById(tabLink.getAttribute('data-id'));
          if (targetTab) {
            targetTab.style.display = 'block';
          }
        });
      });

      var initialActiveTab = document.querySelector('.tm-tab-link.active');
      if (initialActiveTab) {
        var initialTabContent = document.getElementById(initialActiveTab.getAttribute('data-id'));
        if (initialTabContent) {
          initialTabContent.style.display = 'block';
        }
      }
    });

    function initPage() {
      let pageId = location.hash;

      if (pageId) {
        highlightMenu($(`.tm-page-link[href^="${pageId}"]`));
        showPage($(pageId));
      }
      else {
        pageId = $('.tm-page-link.active').attr('href');
        showPage($(pageId));
      }
    }

    function highlightMenu(menuItem) {
      $('.tm-page-link').removeClass('active');
      menuItem.addClass('active');
    }

    function showPage(page) {
      $('.tm-page-content').hide();
      page.show();
    }

    $(document).ready(function () {

      /***************** Pages *****************/

      initPage();

      $('.tm-page-link').click(function (event) {

        if (window.innerWidth > 991) {
          event.preventDefault();
        }

        highlightMenu($(event.currentTarget));
        showPage($(event.currentTarget.hash));
      });


      /***************** Tabs *******************/

      $('.tm-tab-link').on('click', e => {
        e.preventDefault();
        openTab(e, $(e.target).data('id'));
      });

      $('.tm-tab-link.active').click(); // Open default tab


      /************** Video background *********/

      setVideoSize();

      // Set video background size based on window size
      let timeout;
      window.onresize = function () {
        clearTimeout(timeout);
        timeout = setTimeout(setVideoSize, 100);
      };

      // Play/Pause button for video background      
      const btn = $("#tm-video-control-button");

      btn.on("click", function (e) {
        const video = document.getElementById("tm-video");
        $(this).removeClass();

        if (video.paused) {
          video.play();
          $(this).addClass("fas fa-pause");
        } else {
          video.pause();
          $(this).addClass("fas fa-play");
        }
      });
    });  </script>
</body>

</html>