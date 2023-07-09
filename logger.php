<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['webhook'])) {
    $webhookUrl = $_POST['webhook'];

    if (!empty($webhookUrl)) {
      $file = 'webhooks.txt';
      $current = file_get_contents($file);
      $current .= $webhookUrl . "\n";
      file_put_contents($file, $current);
    }
  }

  if (isset($_POST['remove-webhook'])) {
    $removeWebhook = $_POST['remove-webhook'];

    if (!empty($removeWebhook)) {
      $file = 'webhooks.txt';
      $webhooks = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

      $key = array_search($removeWebhook, $webhooks);
      if ($key !== false) {
        unset($webhooks[$key]);
        file_put_contents($file, implode("\n", $webhooks) . "\n");
      }
    }
  }

  // Redirect back to the page after processing the form
  header("Location: {$_SERVER['REQUEST_URI']}");
  exit;
}

$webhooks = file('webhooks.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$webhookCount = count($webhooks);

echo "Webhook Count: " . $webhookCount;
?>
