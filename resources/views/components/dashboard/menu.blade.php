<div class="position-fixed border-right shadow-sm bg-white pl-3 w-25 pr-5 h-100" id = "menu_wrap">
    <h4 class="text-right pt-3" id="close_menu">
        <i class="fas fa-times"></i>
    </h4>
    <div class="pt-3 pb-5" id="menu_items_list">
        <a href="/dashboard" class="text-muted font-weight-bold d-block mb-3">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
        <a href="/households" class="text-muted font-weight-bold d-block mb-3">
            <i class="fas fa-home"></i>
            Households
        </a>
        <a href="/users/{{ Auth::id() }}/edit" class="text-muted font-weight-bold d-block mb-3">
            <i class="fas fa-cogs"></i>
            Account Settings
        </a>
        <form method="POST" action="/logout" class="d-inline-block">
            @csrf
            <button type="submit" class="rounded shadow-sm border py-1 px-3 bg-info text-white">
                Log Out
            </button>
        </form>
    </div>
</div>