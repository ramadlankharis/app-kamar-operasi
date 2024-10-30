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
    {{-- <div id="app">
        <h2>Chat Room 1</h2>
        <div id="messages"
             style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px; height: 300px; overflow-y: scroll;">
            <!-- Messages will be displayed here -->
        </div>
    </div>
    <div id="app">
      <h2>Chat Room 2</h2>
      <div id="messages-1"
           style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px; height: 300px; overflow-y: scroll;">
          <!-- Messages will be displayed here -->
      </div>
  </div> --}}
  @foreach ($rooms as $room)
    <div id="app">
        <h2>Chat Room {{$room->id}}</h2>
        <div id="messages-{{$room->id}}"
             style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px; height: 300px; overflow-y: scroll;">
            <!-- Messages will be displayed here -->
            <div>{{$room->status_operasi}}</div>
        </div>
    </div>
  @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>

      document.addEventListener('DOMContentLoaded', function () {
        const rooms = @json($rooms);  // Data Laravel

        // Loop melalui setiap room dan atur listener Echo
        rooms.forEach(room => {
            console.log(room.id);

            // Ambil elemen messages berdasarkan ID room
            const messagesContainer = document.getElementById(`messages-${room.id}`);

            // Pastikan elemen ditemukan
            if (!messagesContainer) {
                console.error(`Element for room ${room.id} not found!`);
                return;  // Hentikan jika elemen tidak ditemukan
            }

            // Set listener untuk setiap channel Echo
            Echo.channel(`display-channel-${room.id}`)
                .listen('RealTimeDisplay', (e) => {
                    console.log(`Message received for room ${room.id}:`, e);

                    // Buat elemen pesan baru
                    const messageElement = document.createElement('div');
                    messageElement.innerHTML = `<strong>${e.status}:</strong> idRoom ${e.idDisplay}`;

                    // Tambahkan pesan ke dalam container
                    messagesContainer.appendChild(messageElement);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;  // Scroll ke bawah
                });
        });
    });
        // document.addEventListener('DOMContentLoaded', function () {
        //     Echo.channel(`display-channel-1`)
        //         .listen('RealTimeDisplay', (e) => {
        //             const messages = document.getElementById('messages-1');
        //             const messageElement = document.createElement('div');
        //             messageElement.innerHTML = `<strong>${e.status} : </strong> idRoom ${e.idDisplay}`;
        //             messages.appendChild(messageElement);
        //             messages.scrollTop = messages.scrollHeight; // Scroll to the bottom
        //         });
        // })

        // document.addEventListener('DOMContentLoaded', function () {
        //     Echo.channel(`display-channel-2`)
        //         .listen('RealTimeDisplay', (e) => {
        //             const messages = document.getElementById('messages-2');
        //             const messageElement = document.createElement('div');
        //             messageElement.innerHTML = `<strong>${e.status} : </strong> idRoom ${e.idDisplay}`;
        //             messages.appendChild(messageElement);
        //             messages.scrollTop = messages.scrollHeight; // Scroll to the bottom
        //         });
        // })
    
    </script>
   
  </body>
</html>