<?php
$customername = $_GET['customername'] ?? '';
$phone = $_GET['phone'] ?? '';
$email = $_GET['email'] ?? '';
$totalamount = $_GET['amount'] ?? '100'; // default 100
?>
<?php
// Dynamic Festival Theme Logic
$current_date = date('m-d');
$month = date('m');
$theme_color = "#3b82f6"; // Default blue
$festival_name = "";
$festival_icon = "fa-credit-card";

$festivals = [
    '01-01' => ['color' => '#00bcd4', 'name' => 'New Year', 'icon' => 'fa-glass-cheers'],
    '01-14' => ['color' => '#ff9800', 'name' => 'Makar Sankranti', 'icon' => 'fa-sun'],
    '01-26' => ['color' => '#ff9933', 'name' => 'Republic Day', 'icon' => 'fa-flag'],
    '02-14' => ['color' => '#e91e63', 'name' => 'Valentine\'s Day', 'icon' => 'fa-heart'],
    '03-08' => ['color' => '#9c27b0', 'name' => 'Women\'s Day', 'icon' => 'fa-female'],
    '08-15' => ['color' => '#ff9933', 'name' => 'Independence Day', 'icon' => 'fa-flag'],
    '10-31' => ['color' => '#ff5722', 'name' => 'Halloween', 'icon' => 'fa-ghost'],
    '12-25' => ['color' => '#d32f2f', 'name' => 'Christmas', 'icon' => 'fa-tree']
];

if (isset($festivals[$current_date])) {
    $theme_color = $festivals[$current_date]['color'];
    $festival_name = $festivals[$current_date]['name'];
    $festival_icon = $festivals[$current_date]['icon'];
} else {
    if ($month == '12') {
        $theme_color = '#d32f2f'; $festival_name = 'Festive Season'; $festival_icon = 'fa-snowflake';
    } elseif ($month == '10' || $month == '11') {
        $theme_color = '#ff9800'; $festival_name = 'Diwali Season'; $festival_icon = 'fa-fire';
    } elseif ($month == '03') {
        $theme_color = '#e040fb'; $festival_name = 'Holi Season'; $festival_icon = 'fa-paint-roller';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment | MARINE TRADERS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Razorpay -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<link rel="stylesheet" href="css/payment.css">
<style>
  body {
    background: <?php echo $theme_color; ?> !important;
    background-image: linear-gradient(135deg, <?php echo $theme_color; ?> 0%, #1e293b 100%) !important;
  }
  .payment-box {
    border-top: 5px solid <?php echo $theme_color; ?>;
  }
  .btn-pay {
    background: <?php echo $theme_color; ?> !important;
  }
  .festival-badge {
    background: rgba(255,255,255,0.1);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    display: inline-block;
    margin-bottom: 20px;
    font-weight: bold;
    border: 1px solid rgba(255,255,255,0.3);
  }
</style>
</head>

<body>

<div class="payment-box">
  <?php if($festival_name != ""): ?>
  <div class="text-center">
    <div class="festival-badge" style="color: <?php echo $theme_color; ?>; background: rgba(0,0,0,0.05); border-color: <?php echo $theme_color; ?>;">
      <i class="fas <?php echo $festival_icon; ?>"></i> Celebrating <?php echo $festival_name; ?>
    </div>
  </div>
  <?php endif; ?>
  
  <h2><i class="fas <?php echo $festival_icon; ?>" style="color: <?php echo $theme_color; ?>;"></i> Online Payment</h2>

  <div class="mb-3">
    <label>Customer Name</label>
    <input type="text" id="name" class="form-control" value="<?php echo $customername; ?>" required>
  </div>

  <div class="mb-3">
    <label>Email</label>
    <input type="email" id="email" class="form-control" value="<?php echo $email; ?>" required>
  </div>

  <div class="mb-3">
    <label>Phone</label>
    <input type="text" id="phone" class="form-control" value="<?php echo $phone; ?>" required>
  </div>

  <!-- Amount Input -->
  <div class="mb-3">
    <label>Amount (₹)</label>
    <input type="number" id="amount" class="form-control" value="<?php echo $totalamount; ?>" readonly>
  </div>

  <div class="amount-box mb-4">
    Payable Amount: <span id="showAmount"><?php echo $totalamount; ?></span>
  </div>

  <button class="btn-pay" onclick="payNow()">Pay Now</button>
</div>

<script>
// Show amount live
document.getElementById("amount").addEventListener("input",()=>{
  document.getElementById("showAmount").innerText =
  document.getElementById("amount").value || 0;
});

function payNow(){
  let amount = document.getElementById("amount").value;
  let name   = document.getElementById("name").value;
  let email  = document.getElementById("email").value;
  let phone  = document.getElementById("phone").value;

  if(amount=="" || amount<=0){
    alert("Enter Valid Amount");
    return;
  }

  var options = {
    "key": "rzp_test_SLvrGI5oOB3cDO", // ✅ Jay Parmar Test Key
    "amount": amount * 100,
    "currency": "INR",
    "name": "MARINE TRADERS",
    "description": "Product Payment - <?php echo $festival_name; ?>",
    "image": "image/LOGO.jpg",

    "handler": function (response){
      alert("Payment Successful!");
      alert("Payment ID: " + response.razorpay_payment_id);
      // redirect after success
      window.location.href="confirmation.php?order_id="+response.razorpay_payment_id+"&saleprice="+amount+"&payment=online&customername="+name+"&email="+email+"&phone="+phone;
    },

    "prefill": {
      "name": name,
      "email": email,
      "contact": phone
    },

    "theme": {
      "color": "<?php echo $theme_color; ?>"
    }
  };

  var rzp = new Razorpay(options);
  rzp.open();
}
</script>

<?php include 'chatbot.php'; ?>
</body>
</html>

