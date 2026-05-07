<?php
$customername = $_GET['customername'] ?? '';
$phone = $_GET['phone'] ?? '';
$email = $_GET['email'] ?? '';
$totalamount = $_GET['amount'] ?? '100'; // default 100
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
</head>

<body>

<div class="payment-box">
  <h2><i class="fas fa-credit-card"></i> Online Payment</h2>

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
    <label>Amount (â‚¹)</label>
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
    "key": "rzp_test_SLvrGI5oOB3cDO", // âœ… Jay Parmar Test Key
    "amount": amount * 100,
    "currency": "INR",
    "name": "MARINE TRADERS",
    "description": "Product Payment",
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
      "color": "#3b82f6"
    }
  };

  var rzp = new Razorpay(options);
  rzp.open();
}
</script>

<?php include 'chatbot.php'; ?>
</body>
</html>

