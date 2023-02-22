<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $message = $_POST['message'] ?? '';
  if (!empty($message)) {
    $file = fopen('kanta.txt', 'a');
    fwrite($file, "$message\n");
    fclose($file);
    echo "success";
  }
}
?>