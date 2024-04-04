<style>
    /* ==========================Font========================== */

    @font-face {
        font-family: 'robotoregular';
        src: url(../fonts/roboto-regular-webfont.woff) format('woff');
        font-weight: normal;
        font-style: normal;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", "robotoregular", sans-serif;
    }

    body {
        min-height: 100vh;
        background: var(--bg-light);
    }

    nav {
        position: fixed;
        width: 60px;
        height: 100%;
        background: #17a2b8;
        transition: .5s;
        overflow: hidden;
        z-index: 100;
    }

    nav.active {
        width: 300px;
    }

    nav:hover {
        width: 300px;
    }

    nav ul {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    nav ul li {
        list-style: none;
        width: 100%;
        position: relative;

    }

    nav ul li a:hover {
        color: var(--bg-primary) !important;
    }

    nav ul li:hover a::before {
        background-color: white !important;
        width: 100%;
    }

    nav ul li a {
        position: relative;
        display: block;
        width: 100%;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--cl-text) !important;
        transition: .2s;
    }

    nav ul li a::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        transition: .2s;
    }

    nav ul li a .icon {
        position: relative;
        display: block;
        min-width: 60px;
        height: 60px;
        line-height: 60px;
        text-align: center;
    }

    nav ul li a .title {
        position: relative;
        font-size: .85em;
    }

    nav ul li a .icon * {
        font-size: 1.1em;
    }

    nav ul li a.toggle {
        border-bottom: 3px solid white;
    }

    .toggle {
        cursor: pointer;
    }

    header {
        display: none;
    }

    ul li a.active {
        background-color: white;
        color: #41444b !important;
    }

    @media (max-width: 768px) {
        header {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 60px;
            background: var(--bg-secondary);
            color: var(--cl-text);
        }

        header a {
            color: var(--cl-text)
        }

        nav {
            left: -60px;
        }

        nav.active {
            left: 0;
            width: 100%;
        }

        nav ul li a.toggle {
            display: none;
        }
    }

    :root {
        --bg-primary: #41444b;
        --bg-secondary: #52575d;
        --bg-active: #fddb3a;
        --cl-text: #f6f4e6;
    }
</style>
<header>
    <div class="toggle">
        <i class="fas fa-bars"></i>
    </div>
    <h3>Dashboard</h3>
    <a href="#">
        <i class="fas fa-sign-out-alt"></i>
    </a>
</header>
<nav>
    <ul>
        <li>
            <a class="toggle">
                <span class="icon"><i class="fas fa-bars"></i></span>
                <span class="title">Menu</span>
            </a>
        </li>
        <li>
            <a href="{{route('superAdminDashboard')}}" class="active">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{route('superAdminUsers')}}">
                <span class="icon"><i class="fas fa-user"></i></span>
                <span class="title">Users</span>
            </a>
        </li>
        <li>
            <a href="{{route('timeLogs')}}">
                <span class="icon"><i class="fas fa-clock"></i></span>
                <span class="title">Time Logs</span>
            </a>
        </li>
        <li>
            <a href="{{route('manualEntries')}}">
                <span class="icon"><i class="fas fa-user-clock"></i></span>
                <span class="title">Manual Entry</span>
            </a>
        </li>
        <!-- <li>
            <a href="#">
                <span class="icon"><i class="fas fa-info"></i></span>
                <span class="title">Help</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="icon"><i class="fas fa-cog"></i></span>
                <span class="title">Setting</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <span class="title">Password</span>
            </a>
        </li> -->
        <li>
            <a href="{{route('logout')}}">
                <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                <span class="title">Logout</span>
            </a>
        </li>
    </ul>
</nav>
<script>
    var getSidebar = document.querySelector('nav');
    var getToggle = document.getElementsByClassName('toggle');
    for (var i = 0; i <= getToggle.length; i++) {
        getToggle[i].addEventListener('click', function() {
            getSidebar.classList.toggle('active');
        });
    }
</script>
