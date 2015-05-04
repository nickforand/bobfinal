
               
                <?php
                if ($path_parts['filename'] == "index") {
                    print '<p class = "nav">Home      </p>';
                } else {
                    print '<p class = "nav"><a href="index.php">Home       </a></p>';
                }
                if ($path_parts['filename'] == "2015") {
                    print '<p class = "nav">2015 Music     </p>';
                } else {
                    print '<p class = "nav"><a href="2015.php">2015 Music      </a></p>';
                }
                  if ($path_parts['filename'] == "2014") {
                    print '<p class = "nav"> 2014 Music        </p>';
                } else {
                    print '<p class = "nav"><a href="2014.php">2014 Music      </a></p>';
                }
                  if ($path_parts['filename'] == "future") {
                    print '<p class = "nav"> Upcoming albums        </p>';
                } else {
                    print '<p class = "nav"><a href="future.php">Upcoming albums       </a></p>';
                }
                    if ($path_parts['filename'] == "form") {
                    print '<p class = "nav"> Sign up for email alerts!     </p>';
                } else {
                    print '<p class = "nav"><a href="form.php">Sign up for email alerts!       </a></p>';
                }
                    if ($path_parts['filename'] == "aboutUs") {
                    print '<p class = "nav">About Us       </p>';
                } else {
                    print '<p class = "nav"><a href="aboutUs.php">About Us     </a></p>';
                }
                if ($path_parts['filename'] == "assignment5.0/data/registration.php") {
                    print '<p class = "nav">Data Table       </p>';
                } else {
                    print '<p class = "nav"><a href="/data/registration.php">Data Table    </a></p>';
                }
                
                
                
                ?>
