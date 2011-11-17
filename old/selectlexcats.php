<?php
// Connecting.  Params are hostname, username, password
$link = mysql_connect('localhost', 'AKBelew', 'connor')
    or die('Could not connect: ' . mysql_error());
echo "Connected successfully\n";


//set search parameter
$search="fricative";

// Performing SQL query
$query = sprintf("SELECT * FROM lexicalCategory", mysql_real_escape_string($search));
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
//we can call result in a fetch function to get a row at a time

// Printing results in HTML
echo "<table>\n";
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>
