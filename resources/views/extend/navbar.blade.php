<div class="user-profile">
    <img src="{{ auth()->check() ? 'https://ui-avatars.com/api/?name=' . substr(auth()->user()->name, 0, 1) . '&background=4F46E5&color=fff&rounded=true' : 'https://ui-avatars.com/api/?name=User&background=4F46E5&color=fff&rounded=true' }}" 
         alt="User" 
         class="cdn-avatar user-avatar"
         width="40" 
         height="40">
</div> 