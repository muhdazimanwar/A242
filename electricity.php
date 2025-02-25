<?php
function calculateElectricityCharge($voltage, $current, $rate) {
    // Calculate Power in Watts
    $power = $voltage * $current;
    
    // Create an array to store hourly charges
    $hourlyCharges = [];
    
    for ($hour = 1; $hour <= 24; $hour++) {
        // Calculate Energy in kWh
        $energy = ($power * $hour) / 1000;
        
        // Calculate Total Charge in RM
        $total_charge = round($energy * ($rate / 100), 2);
        
        $hourlyCharges[$hour] = [
            'energy' => $energy,
            'total_charge' => $total_charge
        ];
    }
    
    return [$power, $hourlyCharges];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voltage = floatval($_POST['voltage']);
    $current = floatval($_POST['current']);
    $rate = floatval($_POST['rate']);

    list($power, $hourlyCharges) = calculateElectricityCharge($voltage, $current, $rate);
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
                <label for="rate">Current Rate (sen/kWh):</label>
                <input type="number" step="any" class="form-control" name="rate" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Calculate</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
            <div class="mt-4 p-3 bg-light border rounded">
                <h4>Results:</h4>
                <p><strong>Power (Watt):</strong> <?= number_format($power, 2) ?> W</p>
                <h4>24-Hour Electricity Cost Table</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hour</th>
                            <th>Energy (kWh)</th>
                            <th>Total Charge (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hourlyCharges as $hour => $data) : ?>
                            <tr>
                                <td><?= $hour ?></td>
                                <td><?= number_format($data['energy'], 4) ?> kWh</td>
                                <td>RM <?= number_format($data['total_charge'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
