<h2 align="center">The Latest Recipes</h2><br>
<?php

$con = mysql_connect("localhost", "test", "test") or die('Sorry, could not connect to database server');

mysql_select_db("recipe", $con) or die('Sorry, could not connect to database');

$query = "SELECT recipeid,title,poster,shortdesc from recipes order by recipeid desc limit 0,5";
$result = mysql_query($query) or die('Sorry, could not get recipes at this time ');

if (mysql_num_rows($result) == 0)
{
   echo "<h3>Sorry, there are no recipes posted at this time, please try back later.</h3>";
} else
{
   while($row=mysql_fetch_array($result, MYSQL_ASSOC))
   {
       $recipeid = $row['recipeid'];
       $title = $row['title'];
       $poster = $row['poster'];
       $shortdesc = $row['shortdesc'];
       echo "<a href=\"index.php?content=showrecipe&id=$recipeid\">$title</a> submitted by $poster<br>\n";
       echo"$shortdesc<br><br>\n";
   }
}
?>