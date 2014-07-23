<?php
//ลลดํสนำร
function shutDownFunction() {
    $error = error_get_last();
    if ($error['type'] == 1) {
       var_dump($error);
    }
}
register_shutdown_function('shutdownFunction');
include('index.php');
?>