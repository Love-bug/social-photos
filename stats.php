<?php
$tables = array(
                array(
                    "table" => "transfers",
                    "fields" => "count(1)"
                    ),
                array(
                    "table" => "takeout_jobs_raw",
                    "fields" => "count(1),time_ago(max(ctime))"
                    ),
                array(
                    "table" => "transfer_sizes",
                    "fields" => "kb,mb,gb"
                    ),
                array(
                    "table" => "transfers_by_network order by last_transfer_diff desc",
                    "fields" => "\"from\",\"to\",\"count\",last_transfer"
                    )
               );
if ($_GET['password'] != "anacondA") {
    header("Location: http://socialphotos.net");
    exit();
}

include 'utils/db_utils.php';

function print_header($fields) {
    echo "<tr>";
    foreach($fields as $field) {
        echo "<th>" . trim($field, "\"") . "</th>";
    }
    echo "</tr>";
}

function print_data($query) {
    $result2 = pg_query($query);
    $fields = array();
    if(pg_num_rows($result2)) {
        while($row2 = pg_fetch_row($result2)) {
            echo '<tr>';
            foreach($row2 as $key=>$value) {
                echo '<td>',$value,'</td>';
            }
            echo '</tr>';
        }
    }
}

function html($table, $fields) {
    $db = open_db();
    echo '<h3>',$table,'</h3>';
    echo '<table border=1>';
    print_header(explode(",", $fields));
    print_data("SELECT {$fields} FROM {$table};");
    echo '</table>';
    close_db($db);
}

?>

<html>
<head>
    <title>Stats</title>
</head>
<body>
<?php

foreach($tables as $table) {
    html($table['table'], $table['fields']);
}

?>
</body>
</html>
