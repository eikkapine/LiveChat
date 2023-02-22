<?php
if (file_exists('kanta.txt')) {
  $messages = file('kanta.txt');
  foreach ($messages as $message) {
    echo '<div class="chat-message"><p>' . htmlentities($message) . '</p></div>';
  }
}
?>