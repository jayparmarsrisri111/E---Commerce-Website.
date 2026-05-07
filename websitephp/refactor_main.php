<?php
$files = [
    'HOME PAGE WEBSITE.php',
    'About.php',
    'pr.php',
    'orderpage.php',
    'orders.php',
    'Enquery form.php',
    'contact us.php',
    'product_detail.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);

    // Replace navbar
    // Starts with <nav class="navbar or <!-- Navbar --> <nav
    $navbar_pattern = '/(?:<!-- Navbar -->\s*)?<nav class="navbar[^>]*>.*?<\/nav>/is';
    $navbar_replacement = "<?php include_once('includes/navbar.php'); ?>";
    $content = preg_replace($navbar_pattern, $navbar_replacement, $content, 1);

    // Replace footer
    // Starts with <footer or <!-- Footer --> <footer
    $footer_pattern = '/(?:<!-- Footer -->\s*)?<footer[^>]*>.*?<\/footer>/is';
    $footer_replacement = "<!-- Footer -->\n<?php include_once('includes/footer.php'); ?>";
    $content = preg_replace($footer_pattern, $footer_replacement, $content, 1);

    file_put_contents($file, $content);
    echo "Refactored $file\n";
}
?>
