<aside>
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Banner</a></li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        <!-- Add more links here -->
    </ul>
</aside>
