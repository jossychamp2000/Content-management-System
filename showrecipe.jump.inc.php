<?php
$con = mysql_connect("localhost", "test", "test") or die('Sorry, could not connect to server');
mysql_select_db("recipe", $con) or die('Sorry, could not connect to database');
$recipeid = $_GET['id'];
$query = "SELECT title,poster,shortdesc,ingredients,directions FROM recipes WHERE recipeid = $recipeid";
$result = mysql_query($query) or die('Sorry, could not find recipe requested');
$row = mysql_fetch_array($result, MYSQL_ASSOC) or die('No records retrieved');
$title = $row['title'];
$poster = $row['poster'];
$shortdesc = $row['shortdesc'];
$ingredients = $row['ingredients'];
$directions = $row['directions'];
$ingredients = nl2br($ingredients);
$directions = nl2br($directions);
echo "<h2>$title</h2>\n";
echo "by $poster<br><br>\n";
echo $shortdesc ."<br><br>\n";
echo "<h3>Ingredients:</h3>";
echo $ingredients ."<br><br>\n";
echo "<h3>Directions:</h3>";
echo $directions ."\n";
echo "<br><br>\n";

$query = "SELECT count(commentid) FROM comments WHERE recipeid = $recipeid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

if ($row[0]== 0)
{
   echo "No comments posted yet. &nbsp;&nbsp;\n";
   echo "<a href=\"index.php?content=newcomment&id=$recipeid\">Add a comment</a>\n";

   echo "<a href=\"print.php?id=$recipeid\"target=\"_blank\">&nbsp; Print recipe</a>\n";
   echo "<hr>\n";
} else
{
   $totrecords = $row[0];
   echo $row[0] . "\n";
   echo " comments posted. \n";
   echo "<a href=\"index.php?content=newcomment&id=$recipeid\">Add a comment</a>\n";
   echo " <a href=\"print.php?id=$recipeid\" target=\"_blank\">Print recipe</a>\n";
   echo "<hr>\n";
   echo "<h2>Comments:</h2>\n";
   if (!isset($_GET['page']))
      $thispage = 1;
   else
      $thispage = $_GET['page'];
   $recordsperpage = 5;
   $offset = ($thispage - 1) * $recordsperpage;
   $totpages = ceil($totrecords / $recordsperpage);
   $query = "SELECT date,poster,comment from comments where recipeid = $recipeid order by commentid desc limit $offset,$recordsperpage";
   $result = mysql_query($query) or die('Could not retrieve comments: ' . mysql_error());
   while($row = mysql_fetch_array($result, MYSQL_ASSOC))
   {
      $date = $row['date'];
      $poster = $row['poster'];
      $comment = $row['comment'];
      $comment = nl2br($comment);
      echo $date . " - posted by " . $poster . "\n";
      echo "<br>\n";
      echo $comment . "\n";
      echo "<br><br>\n";
   }
   echo "Displaying page $thispage of $totpages";
   echo "<form action=\"index.php\" method=\"get\">";
   echo "<input type=\"hidden\" name=\"content\" value=\"showrecipe\">";
   echo "<input type=\"hidden\" name=\"id\" value=\"$recipeid\">";
   echo "Jump to Page:<input type=\"text\" size=\"2\" name=\"page\">";
   echo "<input type=\"submit\" value=\"Go\">";
   echo "</form>";
}
?> 
