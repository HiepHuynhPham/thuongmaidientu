<?php
$host = "dpg-d3ocll3ipnbc73fsstb0-a.singapore-postgres.render.com";
$port = "5432";
$dbname = "fruitshop_9grj";
$user = "fruitshop_user";
$password = "CqdIUBPQ23FVE9t1rCZ70s1MBYOZVhkG";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require");

if ($conn) {
    echo "✅ Kết nối PostgreSQL thành công!";
} else {
    echo "❌ Kết nối PostgreSQL thất bại.";
}
?>
