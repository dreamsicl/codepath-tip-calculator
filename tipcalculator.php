<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Tip Calculator</title>
	</head>
	<body>
    <?php
        $displayResult = $subtotalErr = $splitErr = false;
        
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // check for previous input
            if (isset($_GET["subtotal"])) $subtotal = $_GET["subtotal"];
            else $subtotal = "";

            if (isset($_GET["percent"])) $pc = $_GET["percent"];
            else $pc = 15;

            if (isset($_GET["split"])) $split = $_GET["split"];
            else $split = 1;

            // check validity of input
            if (strlen($subtotal) < 1 || $subtotal <= 0) {
                $subtotalErr = true;
            }
            if (strlen($split) < 1 || $split <= 0) {
                $splitErr = true;
            }

            // calculate & display results only if input is valid
            if (!$splitErr && !$subtotalErr) {
                $displayResult = true;
                $subtotal = clean_input($subtotal);
                $pc = clean_input($pc);
                $tip = $subtotal * ($pc / 100);
                $total = $subtotal + $tip;
                if ($split > 1) {
                    $tip_each = $tip / $split;
                    $total_each = $total / $split;
                }
            }
        }
        function clean_input($input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }
    ?>
        <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default" style="margin-top: 50px">
            <div class="panel-heading"><h2 style="margin: 5">Tip Calculator</h2></div>
            <div class="panel-body">
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                <div class="form-group row <?php if ($subtotalErr) echo "has-error" ?>">
                    <label for="subtotal" class="col-sm-3 control-label">Bill subtotal: </label>
                    <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input class="form-control" name="subtotal" type="text" value="<?php echo $subtotal;?>"></input>
                    </div>
                    <?php if ($subtotalErr) echo "<span class='help-block'>Your subtotal needs to be a number greater than 0.</span>";?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="percent" class="col-sm-3 control-label">Tip percentage:</label>
                    <div class="col-sm-8 container-row">
                    <?php
                        for ($percent = 10; $percent <= 20; $percent = $percent + 5) {
                            echo "<label class='radio-inline'><input type='radio' name='percent' value='$percent'";
                            if ((isset($pc) && $percent == $pc) || (!isset($pc) && $percent == 15))
                                echo "checked";
                            echo ">$percent% </label>";
                        }
                    ?>
                    </div>
                </div>
                <div class="form-group row <?php if ($splitErr) echo "has-error" ?>">
                    <label for="split" class="control-label col-sm-3">Split between:</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input class="form-control" type="text" name="split" value="<?php echo $split?>"></input> 
                            <span class="input-group-addon">person(s)</span>
                        </div>
                        <?php if ($splitErr) echo "<span class='help-block'>You can only split the bill between one or more persons.</span>";?>
                    </div>
                </div>
                <button type="submit" class="btn btn-default btn-block">Submit</button>
            </form>
            </div>

            <?php 
                if ($displayResult) {
                    echo "<table class='table table-bordered table-striped'>
                          <tr><th>Tip</th><th>Total</th>";
                    if ($split > 1) {
                        // render Tip/Total Each headers only if splitting with >1 person
                        echo "<th>Tip Each</th><th>Total Each</th>";
                    }
                    echo"</tr><tr><td>$";
                    echo number_format((float) $tip, 2, ".", "");
                    echo "</td><td>$";
                    echo number_format((float) $total, 2, ".","");
                    echo "</td>";

                    if ($split > 1) {
                        // render Tip/Total Each actuals only if splitting with >1 person
                        echo "<td>$";
                        echo number_format((float) $tip_each, 2, ".", "");
                        echo "</td><td>$";
                        echo number_format((float) $total_each, 2, ".","");
                    }
                    echo "</tr></table>";
                }
            ?>
            </div>
            </div>
            </div>
        </div>
	</body>
</html>