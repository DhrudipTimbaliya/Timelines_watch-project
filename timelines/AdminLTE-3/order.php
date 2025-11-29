<?php include_once("include/header.php"); ?>
    <!-- Main content -->
  <div class="content-wrapper" id="oder_bg">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Order Table</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashbord.php">Home</a></li>
              <li class="breadcrumb-item active">Order Table</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

<?php
// Include database connection
include __DIR__ . '/../php/connection.php';

// Fetch orders
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>

<h2 style="text-align:center;color:blue;">Orders Table</h2>

<table id="order_table" style="text-align:center;" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th>order_id</th>
            <th>user_id</th>
            <th>product Details</th>
            <th>address</th>
            <th>shipping</th>
            <th>shipping_amt</th>
            <th>tax</th>
            <th>total</th>
            <th>order_status</th>
            <th>created_at</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                $decoded = json_decode($row['product_id'], true);
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['order_id']); ?></td>
                    <td><?= htmlspecialchars($row['user_id']); ?></td>
                    <td>
                        <?php
                        $product_data = $row['product_id'];
                        $decoded = json_decode($product_data, true);
                    
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            foreach ($decoded as $product) {
                                if (is_array($product)) {
                                    foreach ($product as $key => $val) {
                                       echo '<table border="1" style="border-collapse:collapse; width:100%;">';
                                       echo '<tbody>';
                                       echo '<tr>';
                                       echo '<td style="width:100px;"><strong>' . htmlspecialchars($key) . '</strong></td>'; // Set width
                                       echo '<td>' . htmlspecialchars($val) . '</td>';
                                       echo '</tr>';
                                       echo '</tbody>';
                                       echo '</table>';
                                    }
                                } else {
                                    echo htmlspecialchars($product) . '<br>';
                                }
                                echo '<hr style="border:none;border-top:5px solid #ccc;margin:4px 0;">';
                            }
                        } else {
                            echo '<div >';
                            echo '<strong> Raw Data:</strong> ' . htmlspecialchars($product_data) . '<br>';
                            echo '<small style="color:#a00;">JSON Error: ' . json_last_error_msg() . '</small>';
                            echo '</div>';
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($row['address']); ?></td>
                    <td><?= ucfirst(htmlspecialchars($row['shipping'])); ?></td>
                    <td>₹<?= number_format($row['shipping_amt'], 2); ?></td>
                    <td>₹<?= number_format($row['tax'], 2); ?></td>
                    <td>₹<?= number_format($row['total'], 2); ?></td>
                     <td>
                                  <select id="status_<?= $row['order_id']; ?>" 
                                          style="width:120px; padding:5px; border:1px solid #ccc; border-radius:5px; font-size:14px;">
                                      <option value="Pending" <?= $row['order_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                      <option value="Processing" <?= $row['order_status'] == 'Processing' ? 'selected' : ''; ?>>Processed</option>
                                      <option value="Shipped" <?= $row['order_status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                      <option value="Delivered" <?= $row['order_status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                  </select>
                              
                                  <button onclick="updateStatus(<?= $row['order_id']; ?>)" 
                                          style="background:#007bff; color:#fff; border:none; padding:6px 12px; font-size:14px; margin-left:5px; border-radius:5px; margin-top:5px; cursor:pointer;">
                                      Update
                                  </button>
                              
                                  <span id="msg_<?= $row['order_id']; ?>" style="color:green; font-size:12px; margin-left:5px;"></span>
                     </td>

                    <td><?= htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="10" style="text-align:center;">No orders found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<script>
function updateStatus(orderId) {
    var newStatus = $('#status_' + orderId).val();

    $.ajax({
        url: 'include/update_status.php',
        type: 'POST',
        data: {
            order_id: orderId,
            status: newStatus
        },
        success: function(response) {
            $('#msg_' + orderId).text(response).fadeIn().delay(4000).fadeOut();
        },
        error: function(xhr, status, error) {
            alert('Error: ' + error);
        }
    });
}
</script>

<?php include_once("include/footer.php"); ?>