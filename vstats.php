<?php


/*
Plugin Name: VStats
Plugin URI: http://blog.javalog.de
Description: VStats Plugin (WassUp Plugin required! http://www.wpwp.org )
Author: Alexander Gerk
Version: 1.01
Author URI: http://blog.javalog.de/
Author Email: info@javalog.de
*/

// NOTE: WassUp Plugin required! http://www.wpwp.org !!!!!!!!!!

/*-----------------   SYSTEM INFORMATION   ------------------------------------*/

$hostname = "localhost";		// add your host here 99% localhost
$username = "username";		// add your username here
$password = "password";		// add your password here
$database = "databasename";	// add your databasename here

/*-----------------------------------------------------------------------------*/


define("host", $hostname);
define("user", $username);
define("pass", $password);
define("db", $database);


// Main function Visits
function widget_Visits($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>VStats
 <?php
  echo $after_title;readVisits("visits","Visits");
  echo readVisits("pageviews","Pageviews");
  echo readLast24();
  echo readDayBefor("Day before"); 
  //echo readStartdate("first count");
  echo readLastWeek("Last Week");	 
  echo showFooter();  
  echo $after_widget;
}


// Footer
function showFooter() {
$text = "<ul><li style='font-size:7pt; color:#bbb;'>".__("designed by", "Alexander Gerk")." <a style='color:#777;' href='http://blog.javalog.de' title='VisitStats PlugIn - by Alexander Gerk'>Alexander Gerk</a></li></ul>";
echo $text;
}

// read last 24 h
function readLast24() {
$sql = "select count(distinct(wassup_id))as lastentry from wp_wassup where timestamp >= unix_timestamp(now()) - 60*60*24";
mysql_connect (host, user, pass);
$result = mysql_db_query (db, $sql);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))  {
echo "<ul><li><label style='padding:0 4px 0 4px;background:#5b79a3;color:#fff;'>".$row["lastentry"]."</label> Last 24h</li></ul>";

}
mysql_free_result ($result);
}

// read day befor between 48 h and 24 h
function readDayBefor($caption) {
$sql = "select count(distinct(wassup_id))as daybefor from wp_wassup where timestamp >= (unix_timestamp(now())- 60*60*48) and timestamp <= (unix_timestamp(now())-60*60*24)";
mysql_connect (host, user, pass);
$result = mysql_db_query (db, $sql);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))  {
echo "<ul><li><label style='padding:0 4px 0 4px;background:#5b79a3;color:#fff;'>".$row["daybefor"]."</label> ".$caption."</li></ul>";
}
mysql_free_result ($result);
}



// read Last Week between now h and 168 h
function readLastWeek($caption) {
$sql = "select count(distinct(wassup_id))as lw from wp_wassup where timestamp >= (unix_timestamp(now())- 60*60*168)";
mysql_connect (host, user, pass);
$result = mysql_db_query (db, $sql);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))  {
echo "<ul><li><label style='padding:0 4px 0 4px;background:#db6667;color:#fff;'>".$row["lw"]."</label> ".$caption."</li></ul>";
}
mysql_free_result ($result);
}


// read Visits
function readVisits($var, $caption) {
$sql = "select count(distinct(wassup_id))as visits, count(wassup_id)as pageviews from wp_wassup";
mysql_connect (host, user, pass);
$result = mysql_db_query (db, $sql);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))  {
echo "<ul><li><label style='padding:0 4px 0 4px;background:#368ff0;color:#fff;'>".$row[$var]."</label> ".$caption."</li></ul>";
}
mysql_free_result ($result);
}

// init Visits
function Visits_init()
{
  register_sidebar_widget(__('VStats'), 'widget_Visits'); 
}
add_action("plugins_loaded", "Visits_init");


?>