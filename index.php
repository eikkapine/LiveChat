<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'] ?? '';
    if (!empty($message)) {
        $file = fopen('kanta.txt', 'a');
        fwrite($file, "$message\n");
        fclose($file);
	echo '<script>window.location.reload()</script>';
    }
    exit;
}

if (isset($_GET['latest_message'])) {
    $messages = file('kanta.txt');
    $latest_message = end($messages);
    echo htmlentities($latest_message);
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>ChatGPT</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }
        .chat-box {
            margin: 0 auto;
            max-width: 600px;
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }
        .chat-header {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chat-header h2 {
            margin: 0;
            font-size: 18px;
        }
        .chat-body {
            height: 400px;
            overflow-y: scroll;
            padding: 10px;
        }
        .chat-message {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .chat-message p {
            margin: 0;
        }
        .chat-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #f1f1f1;
            padding: 10px;
            display: flex;
        }
        .chat-input {
            flex: 1;
            margin-right: 10px;
            padding: 10px;
            border-radius: 5px;
            border: none;
        }
        .chat-button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
        }
        .chat-button:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="chat-box">
        <div class="chat-header">
            <h2>ChatGPT</h2>
        </div>
        <div class="chat-body" id="chat-body">
            <?php
            if (file_exists('kanta.txt')) {
                $messages = file('kanta.txt');
                foreach ($messages as $message) {
                    echo '<div class="chat-message"><p>' . htmlentities($message) . '</p></div>';
                }
            }
            ?>
        </div>
        <div class="chat-footer">
            <form method="post" id="chat-form" onsubmit="sendMessage(event)">
                <input type="text" class="chat-input" name="message" placeholder="Type your message...">
                <button type="submit" class="chat-button">Send</button>
            </form>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
  // Function to refresh messages
  function refreshMessages() {
    $.ajax({
      url: "get_messages.php",
      success: function(data) {
        $(".chat-body").html(data);
        // Scroll to bottom of chat body
        var chatBody = document.querySelector('.chat-body');
        chatBody.scrollTop = chatBody.scrollHeight;
      }
    });
  }

  // Refresh messages every 5 seconds
  setInterval(refreshMessages, 5000);

  // Submit form via AJAX
  $("form").submit(function(event) {
    event.preventDefault();
    $.ajax({
      url: "send_message.php",
      type: "POST",
      data: $(this).serialize(),
      success: function() {
        // Clear input field
        $("input[name='message']").val("");
        // Refresh messages
        refreshMessages();
      }
    });
  });
});
</script>
</html> 