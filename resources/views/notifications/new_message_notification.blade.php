<li class="notifications {{$notification->unread()?'unread':''}}">

		<a href="{{  $notification->unread() ? route('notifications.show',['notifications_id' => $notification->id]).'?query='.route('messages.show',['dialog_id' => $notification->data['dialog_id']]) : route('messages.show',['dialog_id' => $notification->data['dialog_id']]) }}">
			{{ $notification->data['name'] }} 发了私信给你，请查收！
		</a>
		<span class="notify">{{ formatTime($notification->created_at->format('Y-m-d H:i:s')) }}</span>
</li>