<?php
session_start();
include('configpage.php');

// Fetch the specific order if ID is provided, else fetch the most recent
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM orderss WHERE id = $id LIMIT 1";
} else {
    $query = "SELECT * FROM orderss ORDER BY id DESC LIMIT 1";
}
$result = mysqli_query($mysqli, $query);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    die("No order found.");
}

$total = (float)$order['totalamount'];
$gst_rate = 0.18; // 18% GST
$base_price = $total / (1 + $gst_rate);
$gst_amount = $total - $base_price;
$qty = (int)$order['qunatity'];
$unit_price = $base_price / ($qty > 0 ? $qty : 1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tax Invoice #MT-<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></title>
  <link rel="icon" href="image/LOGO.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- html2pdf Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  
  <style>
    body { background-color: #eef2f6; font-family: 'Outfit', sans-serif; color: #1e293b; }
    
    .invoice-wrapper {
      max-width: 900px;
      margin: 40px auto;
      background: #ffffff;
      padding: 60px;
      border-radius: 16px;
      box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
      position: relative;
      overflow: hidden;
    }

    .invoice-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 8px;
      background: linear-gradient(90deg, #1e3a8a, #3b82f6, #0ea5e9);
    }

    /* Watermark */
    .watermark {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-30deg);
      font-size: 10rem;
      font-weight: 800;
      color: rgba(59, 130, 246, 0.03);
      white-space: nowrap;
      pointer-events: none;
      z-index: 0;
    }

    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 2px solid #f1f5f9;
      padding-bottom: 30px;
      margin-bottom: 40px;
      position: relative;
      z-index: 1;
    }

    .company-details {
      display: flex;
      align-items: center;
    }

    .company-logo {
      width: 80px;
      height: 80px;
      border-radius: 16px;
      margin-right: 20px;
      box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }

    .company-info h2 {
      color: #0f172a;
      font-weight: 800;
      margin: 0 0 5px 0;
      font-size: 1.8rem;
      letter-spacing: -0.5px;
    }

    .company-info p {
      color: #64748b;
      font-size: 0.95rem;
      line-height: 1.6;
      margin: 0;
    }

    .gst-badge {
      display: inline-block;
      background: #eff6ff;
      color: #2563eb;
      padding: 4px 12px;
      border-radius: 6px;
      font-size: 0.85rem;
      font-weight: 600;
      margin-top: 8px;
      border: 1px solid #bfdbfe;
    }

    .invoice-title {
      text-align: right;
    }

    .invoice-title h1 {
      color: #3b82f6;
      font-weight: 800;
      margin: 0;
      font-size: 3rem;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .invoice-title p.inv-number {
      font-size: 1.2rem;
      color: #0f172a;
      font-weight: 700;
      margin: 5px 0;
    }

    .invoice-title p.inv-date {
      color: #64748b;
      font-size: 0.95rem;
      margin: 0;
    }

    .billing-section {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      margin-bottom: 40px;
      position: relative;
      z-index: 1;
    }

    .billing-card {
      background: #f8fafc;
      padding: 25px 30px;
      border-radius: 12px;
      flex: 1;
      border: 1px solid #e2e8f0;
      position: relative;
      overflow: hidden;
    }

    .billing-card.primary {
      background: #f0f9ff;
      border-color: #bae6fd;
    }

    .billing-card.primary::after {
      content: '\f0d6';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      bottom: -20px;
      right: -10px;
      font-size: 8rem;
      color: rgba(56, 189, 248, 0.05);
    }

    .billing-card h5 {
      color: #475569;
      font-weight: 700;
      margin-bottom: 15px;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 0.85rem;
    }

    .billing-card p {
      margin-bottom: 5px;
      font-size: 0.95rem;
      color: #334155;
    }

    .billing-card .customer-name {
      font-size: 1.25rem;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 10px;
    }

    .table-custom {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-bottom: 40px;
      position: relative;
      z-index: 1;
    }

    .table-custom th {
      background: #0f172a;
      color: #ffffff;
      padding: 16px 20px;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 1px;
      border: none;
    }

    .table-custom th:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    .table-custom th:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

    .table-custom td {
      padding: 20px;
      border-bottom: 1px solid #f1f5f9;
      vertical-align: middle;
      font-size: 1rem;
    }

    .product-desc-title {
      font-weight: 700;
      color: #0f172a;
      font-size: 1.1rem;
      margin-bottom: 4px;
    }

    .product-desc-meta {
      font-size: 0.85rem;
      color: #64748b;
    }

    .totals-container {
      display: flex;
      justify-content: flex-end;
      position: relative;
      z-index: 1;
    }

    .totals-box {
      width: 400px;
      background: #f8fafc;
      border-radius: 12px;
      padding: 25px;
      border: 1px solid #e2e8f0;
    }

    .totals-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      font-size: 1rem;
      color: #475569;
    }

    .totals-row.gst-row {
      color: #64748b;
      font-size: 0.95rem;
    }

    .totals-row.grand-total {
      margin-top: 15px;
      padding-top: 20px;
      border-top: 2px dashed #cbd5e1;
      font-size: 1.5rem;
      font-weight: 800;
      color: #0f172a;
    }

    .totals-row.grand-total .amount {
      color: #10b981;
    }

    .footer-notes {
      margin-top: 60px;
      padding-top: 30px;
      border-top: 2px solid #f1f5f9;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .footer-notes h5 {
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 10px;
    }

    .footer-notes p {
      color: #64748b;
      margin-bottom: 5px;
      font-size: 0.95rem;
    }

    .auth-sign {
      margin-top: 40px;
      text-align: right;
    }

    .auth-sign img {
      width: 150px;
      opacity: 0.8;
      display: block;
      margin-left: auto;
      margin-bottom: 5px;
    }

    .auth-sign span {
      border-top: 1px solid #cbd5e1;
      padding-top: 8px;
      font-size: 0.9rem;
      color: #64748b;
      font-weight: 600;
      display: inline-block;
      width: 180px;
      text-align: center;
    }

    .action-buttons {
      text-align: center;
      margin-bottom: 20px;
    }

    .btn-download {
      background: linear-gradient(135deg, #2563eb, #3b82f6);
      color: white;
      padding: 14px 35px;
      font-size: 1.1rem;
      font-weight: 700;
      border-radius: 50px;
      border: none;
      box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-download:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4);
      background: linear-gradient(135deg, #1d4ed8, #2563eb);
    }

    @media print {
      body { background: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      .invoice-wrapper { box-shadow: none; margin: 0; padding: 0; max-width: 100%; border-radius: 0; }
      .action-buttons { display: none !important; }
      .invoice-wrapper::before { display: none; }
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <div class="action-buttons">
    <button onclick="downloadPDF()" class="btn btn-download"><i class="fas fa-download me-2"></i> Download Premium PDF</button>
  </div>

  <div class="invoice-wrapper" id="invoice">
    <div class="watermark">MARINE TRADERS</div>
    
    <!-- Header -->
    <div class="invoice-header">
      <div class="company-details">
        <img src="image/LOGO.jpg" alt="Logo" class="company-logo">
        <div class="company-info">
          <h2>MARINE TRADERS</h2>
          <p><i class="fas fa-map-marker-alt me-2 text-primary"></i>Alang SBY, North Side Road, Gujarat</p>
          <p><i class="fas fa-phone-alt me-2 text-primary"></i>+91 9712334903 &nbsp;|&nbsp; <i class="fas fa-envelope me-2 text-primary"></i>info@marine.com</p>
          <div class="gst-badge"><i class="fas fa-file-invoice-dollar me-1"></i> GSTIN: 24AAECM1234F1Z9</div>
        </div>
      </div>
      <div class="invoice-title">
        <h1>TAX INVOICE</h1>
        <p class="inv-number">#MT-<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></p>
        <p class="inv-date"><i class="far fa-calendar-alt me-1"></i> <?php echo date('d M Y, h:i A'); ?></p>
      </div>
    </div>

    <!-- Billing Info -->
    <div class="billing-section">
      <div class="billing-card">
        <h5><i class="fas fa-file-invoice me-2 text-secondary"></i> Billed To</h5>
        <div class="customer-name"><?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?></div>
        <p><i class="fas fa-envelope me-2 text-muted"></i> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><i class="fas fa-phone me-2 text-muted"></i> <?php echo htmlspecialchars($order['phone']); ?></p>
        <div class="mt-3 pt-3 border-top border-light">
          <p class="mb-0 fw-semibold text-dark">Shipping Address:</p>
          <p class="text-muted mt-1" style="line-height: 1.5;">
            <?php echo htmlspecialchars($order['address']); ?><br>
            <?php echo htmlspecialchars($order['city']) . ', ' . htmlspecialchars($order['state']); ?><br>
            <?php echo htmlspecialchars($order['country']) . ' - ' . htmlspecialchars($order['pincode']); ?>
          </p>
        </div>
      </div>
      
      <div class="billing-card primary">
        <h5><i class="fas fa-credit-card me-2 text-primary"></i> Payment Summary</h5>
        <div class="mt-4">
            <div class="d-flex justify-content-between mb-3">
              <span class="text-slate-500 fw-medium">Payment Mode</span>
              <span class="badge bg-primary px-3 py-2 text-uppercase rounded-pill shadow-sm"><?php echo htmlspecialchars($order['payment']); ?></span>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <span class="text-slate-500 fw-medium">Order Status</span>
              <span class="fw-bold text-success"><i class="fas fa-check-circle me-1"></i> Paid Successfully</span>
            </div>
            <div class="d-flex justify-content-between mt-4 pt-3" style="border-top: 1px dashed #bae6fd;">
              <span class="text-slate-500 fw-medium">Transaction Ref</span>
              <span class="fw-bold text-slate-800">TXN-<?php echo strtoupper(substr(md5($order['id'].time()), 0, 8)); ?></span>
            </div>
        </div>
      </div>
    </div>

    <!-- Order Table -->
    <table class="table-custom">
      <thead>
        <tr>
          <th width="50%">Item Description</th>
          <th class="text-center" width="15%">Price</th>
          <th class="text-center" width="15%">Qty</th>
          <th class="text-end" width="20%">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <div class="product-desc-title"><?php echo htmlspecialchars($order['productname']); ?></div>
            <div class="product-desc-meta"><i class="fas fa-barcode me-1"></i> SKU: PRD-<?php echo htmlspecialchars($order['productn']); ?></div>
          </td>
          <td class="text-center fw-medium">₹<?php echo number_format($unit_price, 2); ?></td>
          <td class="text-center fw-bold text-primary"><?php echo htmlspecialchars($order['qunatity']); ?></td>
          <td class="text-end fw-bold text-dark fs-5">₹<?php echo number_format($base_price, 2); ?></td>
        </tr>
      </tbody>
    </table>

    <!-- Totals -->
    <div class="totals-container mb-5">
      <div class="totals-box shadow-sm">
        <div class="totals-row">
          <span class="fw-medium">Subtotal (Excl. Tax)</span>
          <span class="fw-bold text-dark">₹<?php echo number_format($base_price, 2); ?></span>
        </div>
        <div class="totals-row gst-row">
          <span>CGST (9%)</span>
          <span>₹<?php echo number_format($gst_amount / 2, 2); ?></span>
        </div>
        <div class="totals-row gst-row">
          <span>SGST (9%)</span>
          <span>₹<?php echo number_format($gst_amount / 2, 2); ?></span>
        </div>
        <div class="totals-row mt-2 pt-2" style="border-top: 1px solid #e2e8f0;">
          <span class="fw-medium">Shipping & Handling</span>
          <span class="fw-bold text-success">₹0.00</span>
        </div>
        <div class="totals-row grand-total">
          <span>Grand Total</span>
          <span class="amount">₹<?php echo number_format($total, 2); ?></span>
        </div>
        <p class="text-center text-muted mt-3 mb-0" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i> Amount is inclusive of all taxes</p>
      </div>
    </div>
    
    <!-- Auth Sign -->
    <div class="auth-sign">
      <!-- Jay Parmar Signature -->
      <div style="height: 60px; font-family: 'Caveat', 'Brush Script MT', cursive; font-size: 2.8rem; color: #0f172a; line-height: 60px; transform: rotate(-3deg); display: inline-block; padding-right: 20px; letter-spacing: 1px;">Jay Parmar</div>
      <br>
      <span>Authorized Signatory</span>
    </div>

    <!-- Footer Notes -->
    <div class="footer-notes">
      <h5>Thank you for your business!</h5>
      <p>This is a computer generated invoice and does not require a physical signature.</p>
      <p class="text-primary fw-semibold mt-2"><i class="fas fa-globe me-1"></i> www.marinetraders.com &nbsp;&nbsp;&bull;&nbsp;&nbsp; <i class="fas fa-shield-alt me-1"></i> 100% Secure & Trusted</p>
    </div>
  </div>
</div>

<script>
  function downloadPDF() {
    const btn = document.querySelector('.action-buttons');
    btn.style.display = 'none';
    
    var element = document.getElementById('invoice');
    var opt = {
      margin:       [10, 0, 10, 0],
      filename:     'MARINE_TRADERS_Tax_Invoice_#MT-<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?>.pdf',
      image:        { type: 'jpeg', quality: 1 },
      html2canvas:  { scale: 3, useCORS: true, letterRendering: true, windowWidth: 1000 },
      jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    html2pdf().set(opt).from(element).save().then(() => {
        btn.style.display = 'block';
    });
  }

</script>

</body>
</html>
