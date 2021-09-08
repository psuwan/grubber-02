<?php
session_start();

// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>
<script>
    alert('ออกจากระบบ');
    window.location.href = './index0.php';
</script>