<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta charset="utf-8" />
    <meta name="description" content="Personal Website" />
    <meta name="keywords" content="Megan Grass, Computer Animation, Video Game Development" />
    <meta name="author" content="Megan Grass" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>NES Video Games</title>

    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />

    <!-- Agency FB, Adobe Fonts -->
    <link rel="stylesheet" href="https://use.typekit.net/dah3clo.css" />

    <!-- Functionality -->
    <script>function goBack() { window.history.back(); }</script>

</head>
<body>

    <!-- Splash -->
    <div class="image image-splash">
        <div class="image-overlay">

            <header>
                <h1><a href="index.html">Megan Grass @ GitHub</a></h1>
            </header>

            <nav>
                <ul>
                    <li><a href="about.html">About</a></li>
                    <li><a href="resources.html">Resources</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>

            <p class="info-text">I'm Megan, a hobbyist developer, tech enthusiast and lifelong IT student.</p>

        </div>
    </div>
    <main>

        <article class="blog">

            <h1>Nintendo Entertainment System (NES)</h1><br>

            <?php

            // Time
            date_default_timezone_set('UTC');
            // Create connection
            $conn = mysqli_connect("localhost", "root", "", "nes");
            // Check connection
            if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
            }

            // Numerical id Value from "Please select a Publisher:" Option in nes.html
            $iPublisher = $_POST["pub_id"];

            // Publisher name
            $sql=mysqli_query($conn, "SELECT publisher.name AS 'Name' FROM publisher WHERE publisher.id = $iPublisher");
            $Publisher=mysqli_fetch_assoc($sql);

            // Total Publisher Amount
            $sql=mysqli_query($conn, "SELECT count(id) AS 'Total Publisher Amount' from video_game WHERE publisher_id = $iPublisher");
            $NES=mysqli_fetch_assoc($sql);

            // Print Results
            if ($NES['Total Publisher Amount']) {

            echo
            $NES['Total Publisher Amount'], " video games published by ", $Publisher["Name"];

            // Query Publisher
            $sql = "SELECT vg.title AS 'Title',
            vg.title_alt AS 'Alternate Title',
            g.name as 'Genre',
            gext.name AS 'Genre-Ext',
            d.name AS 'Developer',
            p.name AS 'Publisher',
            vg.jp_release AS 'JP',
            vg.na_release AS 'NA',
            vg.eu_release AS 'EU',
            vg.program_size AS 'Program Size',
            vg.character_size AS 'Character Size',
            m.name AS 'Mirroring Type'
            FROM video_game AS vg
            INNER JOIN genre AS g ON vg.genre_id = g.id
            INNER JOIN genre AS gext ON vg.genre_alt = gext.id
            INNER JOIN developer AS d ON vg.developer_id = d.id
            INNER JOIN publisher AS p ON vg.publisher_id = p.id
            INNER JOIN mirroring AS m ON vg.mirroring_id = m.id
            WHERE vg.publisher_id = $iPublisher
            ORDER BY vg.id";
            $Publisher = mysqli_query($conn, $sql);

            // Parse Video Games from Publisher
            for ($x = 0; $x < $NES['Total Publisher Amount']; $x++) {
            $VideoGame = mysqli_fetch_assoc($Publisher);
            printf ("
            <article class=\"blog\">

                <h1>%s</h1>

                <div class=\"image blog-image\">
                    <a href=\"nes/%s.html\">
                        <img src=\"images/nes/%s.jpg\" class=\"image-blog\" width=\"256\" height=\"240\" alt=\"Screenshot of %s\" />
                    </a>
                </div>

                <p class=\"blog-description\">
                    Title (alt.): %s
                    Genre: %s\\%s
                    Developer: %s
                    Publisher: %s
                    JP: %s
                    NA: %s
                    EU: %s
                    PRG Size: %s bytes
                    CHR Size: %d bytes
                    Mirroring: %s
                </p>

                <div class=\"blog-button\">
                    <a href=\"nes/%s.html\">Continue Reading</a>
                </div>

            </article>",
            $VideoGame["Title"],
            $VideoGame["Title"],
            $VideoGame["Title"],
            $VideoGame["Title"],
            $VideoGame["Alternate Title"],
            $VideoGame["Genre"],
            $VideoGame["Genre-Ext"],
            $VideoGame["Developer"],
            $VideoGame['Publisher'],
            $VideoGame["JP"],
            $VideoGame["NA"],
            $VideoGame["EU"],
            $VideoGame["Program Size"],
            $VideoGame["Character Size"],
            $VideoGame["Mirroring Type"],
            $VideoGame["Title"]);
            }

            echo
            "<div class=\"blog-button\">
                <button onclick=\"goBack()\">Go Back</button>
            </div>",
            "
        </article>";
        } else {

        echo
        "The publisher ", $Publisher["Name"], " is undocumented at this time (",
        date('l jS \of F Y h:i:s A'), ").",
        "<div class=\"blog-button\">
            <button onclick=\"goBack()\">Go Back</button>
        </div>",
        "</article>";
        }

        mysqli_close($conn);
        ?>

    </main>

    <footer>
        <ul>
            <li>
                <a href="contact.html">Megan Grass</a>
                Site design 2019, Megan Grass
            </li>
            <li>
                Agency FB font designed by David Berlow, &copy; 1995,
                The Font Bureau, Inc. All Rights Reserved.

                Agency FB font Typekit services provided by Adobe Fonts, &copy; 2019
                Adobe. All Rights Reserved.
            </li>
            <li>
                All other properties are &copy; of their respective owners.
            </li>
        </ul>
    </footer>

</body>
</html>