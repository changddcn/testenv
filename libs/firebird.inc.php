<?php
    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        // Connect to the Firebird/Interbase Sybase database management system
        $link = ibase_pconnect("/var/www/sqlmap/dbs/firebird/testdb.fdb", "SYSDBA", "testpass");
        if (!$link) {
            die(ibase_errmsg());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = ibase_query($link, $query);

        if (!$result) {
            if ($show_errors)
                print "<b>SQL error:</b> ". ibase_errmsg() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = ibase_fetch_assoc($result)) {
            // This must stay here for Firebird
            if (!$show_output)
                exit(1);

            print "<tr>";
            foreach ($line as $col_value) {
                print "<td>" . $col_value . "</td>";
            }
            print "</tr>\n";
            if (!$all_results)
                break;
        }

        print "</table>\n";
        print "</body></html>";
    }
?>
