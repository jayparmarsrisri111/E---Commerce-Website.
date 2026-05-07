<?php
$files = [
    'update.php', 
    'orderdisplay.php', 
    'form.php', 
    'enquiries.php', 
    'displayform.php', 
    'contact_messages.php', 
    'orderedit.php', 
    'user_details.php'
];

foreach($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Pattern 1: Replace sidebar
    // We match from <button class="mobile-toggle" ... to the end of <div class="sidebar">...</div>
    // Ensure we don't match beyond into main-content.
    $pattern_sidebar = '/<button class="mobile-toggle" onclick="toggleSidebar\(\)">\s*<i class="[A-Za-z0-9\- ]+"><\/i>\s*<\/button>\s*<!-- Sidebar -->\s*<div class="sidebar" id="sidebar">.*?<!-- Main Content -->/is';
    
    // Pattern 2: Sometimes there's no mobile-toggle comment, just start from <div class="sidebar" id="sidebar">
    $pattern_sidebar_alt = '/<!-- Sidebar -->\s*<div class="sidebar" id="sidebar">.*?<!-- Main Content -->/is';
    
    // Let's use a very robust generic pattern. Match everything from <!-- Sidebar --> (and optional mobile toggle before it)
    $robust_pattern = '/(?:<!-- Mobile Toggle -->\s*<button.*?<\/button>\s*)?<!-- Sidebar -->\s*<div class="sidebar" id="sidebar">.*?<\/div>\s*<!-- Main Content -->/is';
    
    $replacement = "<?php include_once('includes/sidebar.php'); ?>\n\n    <!-- Main Content -->";
    
    $new_content = preg_replace($robust_pattern, $replacement, $content);
    
    // Pattern 3: Insert includes/top_nav.php at the start of main-content if not already there
    // Match <div class="main-content">
    if(strpos($new_content, "includes/top_nav.php") === false) {
        $nav_pattern = '/(<div class="main-content">)\s*/is';
        $nav_replacement = "$1\n        <?php include_once('includes/top_nav.php'); ?>\n        ";
        $new_content = preg_replace($nav_pattern, $nav_replacement, $new_content, 1);
    }
    
    if($new_content !== $content) {
        file_put_contents($file, $new_content);
        echo "Successfully refactored $file\n";
    } else {
        echo "No changes needed or pattern not found in $file\n";
    }
}
?>
