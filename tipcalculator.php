<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Tip Calculator</title>
	</head>
	<body>
    <?php
        $displayResult = $subtotalErr = false;
        
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["subtotal"])) $subtotal = $_GET["subtotal"];
            else $subtotal = 0;

            if (strlen($subtotal) < 1 || $subtotal <= 0) {
                $subtotalErr = true;
            }
            else {
                $displayResult = true;
                $subtotal = clean_input($subtotal);
                $pc = clean_input($_GET["percent"]);
                $tip = $subtotal * ($pc / 100);
                $total = $subtotal + $tip;

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
                <div class="form-group <?php if ($subtotalErr) echo "has-error" ?>">
                    <label for="subtotal" class="col-sm-3 control-label">Bill subtotal: </label>
                    <div class="input-group col-sm-8">
                        <span class="input-group-addon">$</span>
                        <input class="form-control" name="subtotal" type="text" value="<?php echo $subtotal;?>"></input>
                    </div>
                </div>
                <div class="form-group">
                    <label for="percent" class="col-sm-3">Tip percentage: </label>
                    <?php
                        for ($percent = 10; $percent <= 20; $percent = $percent + 5) {
                            echo "<input type='radio' name='percent' value='$percent'";
                            if ((isset($pc) && $percent == $pc) || (!isset($pc) && $percent == 15))
                                echo "checked";
                            echo ">$percent% ";
                        }
                    ?>
                </div>
                <button type="submit" class="btn btn-default btn-block">Submit</button>
            </form>
            </div>
            
            <?php 
                if ($displayResult) {
                    echo "<div class='panel-footer'><p><b>Tip:</b> $";
                    echo number_format((float) $tip, 2, ".", "");
                    echo "</p><p><b>Total:</b> $";
                    echo number_format((float) $total, 2, ".","");
                    echo "</p></div>";
                }
            ?>
            </div>
            </div>
            </div>
        </div>
	</body>
</html>