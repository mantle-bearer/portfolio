<?php
// Database connection settings
$host = 'aws-0-eu-central-1.pooler.supabase.com';
$port = '5432';
$dbname = 'postgres';
$user = 'postgres.gldbjvxwlxxykaqwyeiq';
$password = '7518815';

try {
    // Create a new PDO instance
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
