<?php

    $con = mysql_connect("localhost", "test", "test") or die('Sorry, could not connect to server');
    mysql_select_db("recipe", $con) or die('Sorry, could not connect to database');

    $search = $_GET['searchFor'];
    $words = explode(" ", $search);
    $phrase = implode("%' AND title LIKE '%", $words);
    $query = "SELECT recipeid,title,shortdesc from recipes where title like '%$phrase%'";
    $result = mysql_query($query) or die('Could not query database at this time');

    echo "<h1>Search Results</h1><br><br>\n";
    if (mysql_num_rows($result) == 0)
    {
        echo "<h2>Sorry, no recipes were found with '$search' in them.</h2>";
    } else
    {
        while($row=mysql_fetch_array($result, MYSQL_ASSOC))
        {
            $recipeid = $row['recipeid'];
            $title = $row['title'];
            $shortdesc = $row['shortdesc'];
            echo "<a href=\"index.php?content=showrecipe&id=$recipeid\">$title</a><br>\n";
            echo "$shortdesc<br><br>\n";
        }
    }
?>