<?php
    require 'connect.php';
	$query = "SELECT e.ExpenseId, e.Amount, e.Description, e.ExpenseDate, e.Month, e.Year, u.ImagePath, u.UserId, c.CategoryName
                FROM expenses e 
                INNER JOIN expensecategories c ON e.CategoryId = c.CategoryId
                INNER JOIN users u 			   ON e.UserId = u.UserId
                ORDER BY e.ExpenseDate DESC;";
    $st = $db->prepare($query); // Returns a PDOStatement object.
    $st->execute(); // The query is now executed.
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ClearExpenses - Project</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>

    <body>
        <?php include 'header.php';?>

        <div class="container">
            <div class="row content_block justify-content-between">

                <div class="col-7 product_description">
                    <?php
                    if ($st->rowCount() > 0){
                    $i = 0; ?>

                    <div style="padding-top:30px; padding-bottom:30px;">
                        <table class="worktab">
                            <thead>
                            <tr>
                                <th colspan="2">Description</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th colspan="3">Expense Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($row = $st->fetch()): ?>

                                <tr>
                                    <td><img src="<?php echo $row["ImagePath"];?>" style="border-radius: 50%;" lt="user" width="30" height="30"></td>
                                    <td>
                                        <input type="hidden"   id=<?php echo $row["ExpenseId"]; ?> value=<?php echo $row["ExpenseId"]; ?> />
                                        <input type="text"     id=<?php echo $row["Description"]; ?> value=<?php echo $row["Description"]; ?> />
                                    </td>
                                    <td><input type="text"     id=<?php echo $row["Amount"]; ?> value=<?php echo $row["Amount"]; ?> /></td>
                                    <td><input type="text"     id=<?php echo $row["CategoryName"]; ?> value=<?php echo $row["CategoryName"]; ?> /></td>
                                    <td><input type="text"     id=<?php echo $row["ExpenseDate"]; ?>    value=<?php echo $row["ExpenseDate"]; ?> />   </td>
                                    <td>
                                        <a href='' onclick="this.href='process_post.php?' +
                                                'expenseid='+document.getElementById('<?php echo $row["ExpenseId"]; ?>').value+
                                                '&command=ExpenseUpdate' +
                                                '&description='+document.getElementById('<?php echo $row["Description"]; ?>').value+
                                                '&amount='+document.getElementById('<?php echo $row["Amount"]; ?>').value+
                                                '&category='+document.getElementById('<?php echo $row["CategoryName"]; ?>').value+
                                                '&date='+document.getElementById('<?php echo $row["ExpenseDate"]; ?>').value+
                                                '&img='+document.getElementById('<?php echo $row["ImagePath"]; ?>').value
                                                ">Edit</a>
                                    </td>
                                    <td>
                                        <a href='' onclick="this.href='process_post.php?expenseid='+document.getElementById('<?php echo $row["ExpenseId"]; ?>').value+'&command=ExpenseDelete'">Delete</a>
                                    </td>
                                </tr>

                                <?php
                                $i++;
                            endwhile;
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    // If message is null
                    if (isset($_SESSION["Message"])){ ?>
                    <p style="color:red;"> <?php echo $_SESSION["Message"]; ?></p><?php
                    }
                    } ?>

                </div>


                <!-- VISUALIZATION SECTION -->
                <div class="col-4 posts">

                    <div class="row content_block justify-content-between" style="padding-top:27px;">
                        <div id="piechart_3d" style="width: 370px; height: 250px; border: 1px solid; margin: auto;"></div>
                    </div>

                    <div class="row content_block justify-content-between" style="padding-top:30px;">
                        <div id="chart_div" style="width: 370px; height: 250px; border: 1px solid; margin: auto;"></div>
                    </div>


                    <div class="row content_block justify-content-between" style="padding-top:30px;">
                        <div id="columnchart_values" style="width: 370px; height: 250px; border: 1px solid; margin: auto;"></div>
                    </div>


                </div>


            </div>
        </div>

        <?php include 'footer.php';?>

    </body>
</html>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Expense Postings', 'Count'],
            ['Salaries and Wages', 2],
            ['Utility Expenses', 13],
            ['Administration Expenses', 17],
            ['Depreciation', 12]
        ]);

        // SELECT COUNT(CategoryId), CategoryId FROM expenses GROUP BY CategoryId

        var options = {
            title: '2019 Expense Postings',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Expense Amount'],
            ['September',        0],
            ['October',   12284.00],
            ['November',  20357.00]

        ]);

        // select sum(amount) from expenses where month = 10
        // select sum(amount) from expenses where month = 11

        var options = {
            title: 'Expense Results',
            hAxis: {title: 'Month Report',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>


<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Category", "Amount", { role: "style" } ],
            ["Wages", 3540.00, "#b87333"],
            ["Utility Exp", 898.00, "blue"],
            ["Admin Expenses", 23235.00, "gold"],
            ["Depreciation", 4968.00, "color: #e5e4e2"]
        ]);

        // select sum(amount) from expenses where CategoryId = 1 2 4 6

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            { calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation" },
            2]);

        var options = {
            title: "2019 Expense Amount p/ Category",

            bar: {groupWidth: "95%"},
            legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
</script>