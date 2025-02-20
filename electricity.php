<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voltage = floatval($_POST['voltage']);
    $current = floatval($_POST['current']);
    $hours = floatval($_POST['hours']);
    $rate = floatval($_POST['rate']);

    // Calculate Power in Watts
    $power = $voltage * $current;
    
    // Calculate Energy in kWh
    $energy = ($power * $hours) / 1000;
    
    // Calculate Total Charge in RM
    $total_charge = $energy * ($rate / 100);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Charge Calculator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Electricity Charge Calculator</h2>
        <form method="post" class="mt-4">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number" step="any" class="form-control" name="voltage" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number" step="any" class="form-control" name="current" required>
            </div>
            <div class="form-group">
                <label for="hours">Usage Time (Hours):</label>
                <input type="number" step="any" class="form-control" name="hours" required>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate (sen/kWh):</label>
                <input type="number" step="any" class="form-control" name="rate" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Calculate</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
            <div class="mt-4 p-3 bg-light border rounded">
                <h4>Results:</h4>
                <p><strong>Power (Watt):</strong> <?= number_format($power, 2) ?> W</p>
                <p><strong>Energy Consumption (kWh):</strong> <?= number_format($energy, 2) ?> kWh</p>
                <p><strong>Total Charge (RM):</strong> RM <?= number_format($total_charge, 2) ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
