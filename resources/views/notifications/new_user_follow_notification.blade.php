<li class="notifications">
    <a href="{{ route('people.index',['user' => $notification->data['user_id']]) }}">{{ $notification->data['name'] }}</a> 关注了你
    <span class="notify">{{ formatTime($notification->created_at->format('Y-m-d H:i:s')) }}</span>
</li>