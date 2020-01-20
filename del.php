<?php
namespace MRBS;

require "defaultincludes.inc";

// Get non-standard form variables
$type = get_form_var('type', 'string');
$confirm = get_form_var('confirm', 'string');


// Check the user is authorised for this page
checkAuthorised();

// This is gonna blast away something. We want them to be really
// really sure that this is what they want to do.

if ($type == "room")
{
  // We are supposed to delete a room
  if (isset($confirm))
  {
    // They have confirmed it already, so go blast!
    db()->begin();
    try
    {
      // First take out all appointments for this room
      db()->command("DELETE FROM $tbl_entry WHERE room_id=?", array($room));
      db()->command("DELETE FROM $tbl_repeat WHERE room_id=?", array($room));
      // Now take out the room itself
      db()->command("DELETE FROM $tbl_room WHERE id=?", array($room));
    }
    catch (DBException $e)
    {
      db()->rollback();
      throw $e;
    }
   
    db()->commit();
   
    // Go back to the admin page
    Header("Location: admin.php?area=$area");
  }
  else
  {
    print_header($day, $month, $year, $area, isset($room) ? $room : "");
   
    // We tell them how bad what they're about to do is
    // Find out how many appointments would be deleted
   
    $sql = "SELECT name, start_time, end_time FROM $tbl_entry WHERE room_id=?";
    $res = db()->query($sql, array($room));
    
    if ($res->count() > 0)
    {
      echo "<p>\n";
      echo get_vocab("deletefollowing") . ":\n";
      echo "</p>\n";
      
      echo "<ul>\n";
      
      for ($i = 0; ($row = $res->row_keyed($i)); $i++)
      {
        echo "<li>".htmlspecialchars($row['name'])." (";
        echo time_date_string($row['start_time']) . " -> ";
        echo time_date_string($row['end_time']) . ")</li>\n";
      }
      
      echo "</ul>\n";
    }
   
    echo "<div id=\"del_room_confirm\">\n";
    echo "<p>" .  get_vocab("sure") . "</p>\n";
    echo "<div id=\"del_room_confirm_links\">\n";
    echo "<a href=\"del.php?type=room&amp;area=$area&amp;room=$room&amp;confirm=Y\"><span id=\"del_yes\">" . get_vocab("YES") . "!</span></a>\n";
    echo "<a href=\"admin.php\"><span id=\"del_no\">" . get_vocab("NO") . "!</span></a>\n";
    echo "</div>\n";
    echo "</div>\n";
    output_trailer();
  }
}

if ($type == "area")
{
  // We are only going to let them delete an area if there are
  // no rooms. its easier
  $n = db()->query1("SELECT COUNT(*) FROM $tbl_room WHERE area_id=?", array($area));
  if ($n == 0)
  {
    // OK, nothing there, lets blast it away
    db()->command("DELETE FROM $tbl_area WHERE id=?", array($area));
   
    // Redirect back to the admin page
    header("Location: admin.php");
  }
  else
  {
    // There are rooms left in the area
    print_header($day, $month, $year, $area, isset($room) ? $room : "");
    echo "<p>\n";
    echo get_vocab("delarea");
    echo "<a href=\"admin.php\">" . get_vocab("backadmin") . "</a>";
    echo "</p>\n";
    output_trailer();
  }
}

if ($type == "dependence")
{
   $dep = get_form_var('dep','string');
   db()->command("DELETE FROM $tbl_dependence WHERE id=?", array($dep));
// die("DELETE FROM $tbl_dependence WHERE id=$dep");
   //Redirect back to the admin page
   header("Location: admin.php");
}
