<html>
 <head>
  <title>Reset Users</title>
 </head>
 <body>
 <?php echo '<p>Establishing a connection to an Oracle database.</p>';


// establish a database connection to your Oracle database.
$username = 's3770282';
$password = 'testing11';
$servername = 'talsprddb01.int.its.rmit.edu.au';
$servicename = 'CSAMPR1.ITS.RMIT.EDU.AU';
$connection = $servername."/".$servicename;

$conn = oci_connect($username, $password, $connection);
if(!$conn)
{
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    echo "<script type='text/javascript'>alert('Not Connected');</script>";
}
else
{
    echo "<p>Successfully connected to CSAMPR1.ITS.RMIT.EDU.AU.</p>";

    // testing generic SELECT SQL
    $stid = oci_parse($conn, 'DELETE FROM USERS');
    oci_execute($stid);
}

oci_close($conn);

?>

 </body>
</html>
