<div class="msg me mb-3 sent-message">
    <div class="chat">
        <p class="m-0">{{ $chat['message'] }}</p>
        <div class="time-sent">{{ date('F j, Y - H:i', strtotime($chat['timestamp'])) }}</div>
    </div>
</div>
