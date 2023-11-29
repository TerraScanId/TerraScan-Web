<div class="msg mb-3 received-message">
    <img src="data:image/png;base64,{{ $chat['senderProfile'][0] }}" alt="">
    <div class="chat">
        <div class="profile">
            <span class="username">{{ $chat['senderName'][0] }}</span>
        </div>
        <p class="m-0">{{ $chat['message'] }}</p>
        <div class="time-received">{{ date('F j, Y - H:i', strtotime($chat['timestamp'])) }}</div>
    </div>
</div>
