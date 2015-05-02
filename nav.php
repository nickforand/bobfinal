
                <?php
                if ($path_parts['filename'] == "index") {
                    print '<p> class="activePage">Home</p>';
                } else {
                    print '<p><a href="index.php">Home</a></p>';
                }
                if ($path_parts['filename'] == "2015") {
                    print '<p> class="activePage">2015 Music</p>';
                } else {
                    print '<p><a href="2015.php">2015 Music</a></p>';
                }
                  if ($path_parts['filename'] == "2014") {
                    print '<p> class="activePage">2014 Music</p>';
                } else {
                    print '<p><a href="2014.php">2014 Music</a></p>';
                }
                  if ($path_parts['filename'] == "future") {
                    print '<p> class="activePage">Upcoming albums</p>';
                } else {
                    print '<p><a href="future.php">Upcoming albums</a></p>';
                }
                    if ($path_parts['filename'] == "form") {
                    print '<p> class="activePage">Sign up for email alerts!</p>';
                } else {
                    print '<p><a href="form.php">Sign up for email alerts!</a></p>';
                }
                    if ($path_parts['filename'] == "aboutUs") {
                    print '<p> class="activePage">About Us</p>';
                } else {
                    print '<p><a href="aboutUs.php">About Us</a></p>';
                }
                ?>
