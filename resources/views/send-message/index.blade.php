<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div id="app">
        <h2>Chat Room</h2>
        <div id="messages"
             style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px; height: 300px; overflow-y: scroll;">
            <!-- Messages will be displayed here -->
        </div>
        <input type="text" id="messageInput" placeholder="Type your message here..." autofocus>
        <button onclick="sendMessage()" class="btn btn-primary">Send</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Echo.channel(`chat-channel`)
                .listen('SendMessage', (e) => {
                    const messages = document.getElementById('messages');
                    const messageElement = document.createElement('div');
                    messageElement.innerHTML = `<strong>${e.userName}:</strong> ${e.message}`;
                    messages.appendChild(messageElement);
                    messages.scrollTop = messages.scrollHeight; // Scroll to the bottom
                });
        })
    
        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value;
            messageInput.value = ''; // Clear input
            fetch(`/`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({message: message})
            }).catch(error => console.error('Error:', error));
        }
    
    </script>
   
  </body>
</html>