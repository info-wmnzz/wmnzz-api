<!-- <aside class="admin-sidebar">
    <ul>
        <li>
            <a href="#">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.banner.index') }}">
                <i class="fas fa-image"></i> Banner
            </a>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside> -->
<section class="sidebar">
  <div class="header">
    <a href="#"><span class="focus">Admin</span><span class="unfocus"> Panel</span></a>
    <!-- <button><i class="fa-solid fa-ellipsis-vertical"></i></button> -->
  </div>
  <div class="separator-wrapper">
    <hr class="separator" />
    <label for="minimize" class="minimize-btn">
      <input type="checkbox" id="minimize" />
      <i class="fa-solid fa-angle-left"></i>
    </label>
  </div>
  <div class="navigation">
    <div class="section main-section">
      <!-- <div class="title-wrapper">
        <span class="title">Main</span>
      </div> -->
      <ul class="items">
        <li class="item">
          <a href="{{route('dashboard')}}">
            <i class="fa-solid fa-house"></i>
            <span class="item-text">Dashboard</span>
            <span class="item-tooltip">Dashboard</span>
          </a>
        </li>
        <li class="item">
          <a href="{{ route('admin.banner.index') }}">
            <i class="fa-solid fa-image"></i>
            <span class="item-text">Banner</span>
            <span class="item-tooltip">Banner</span>
          </a>
        </li>

        <li class="item">
          <a href="{{ route('logout') }}">
                        <i class="fa-solid fa-right-from-bracket"></i>
            <span class="item-text">Logout</span>
            <span class="item-tooltip">Logout</span>
          </a>
        </li>
      </ul>
    </div>
    <!-- <div class="section settings-section">
      <div class="title-wrapper">
        <span class="title">Settings</span>
      </div>
      <ul class="items">
        <li class="item">
          <a href="#">
            <i class="fa-solid fa-bell"></i>
            <span class="item-text">Notifications</span>
            <span class="item-tooltip">Notifications</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <i class="fa-solid fa-gear"></i>
            <span class="item-text">Settings</span>
            <span class="item-tooltip">Settings</span>
          </a>
        </li>
      </ul>
    </div> -->
  </div>
</section>
