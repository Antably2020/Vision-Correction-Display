
<?php
session_start();
session_destroy();
header("http://localhost/Vision-Correction-Display/quiz/color-test.php");

?>
<script>
window.onload = function() {
    // similar behavior as an HTTP redirect
    window.location.replace("http://localhost/Vision-Correction-Display/quiz/color-test.php");
}
</script>