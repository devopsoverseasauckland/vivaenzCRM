<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 ">
        
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/index">
        <img src="https://vivaenz.com/wp-content/uploads/2019/10/logo-nueva-zelanda-white.png" alt="Viva en New Zealand" class="mx-auto img-fluid" width="140" height="32" />
    </a>
    <span class="w-100 text-light bg-dark" >
        Bienvenido(a), {{ Auth::user()->name }}
    </span>

    @guest

    @else

        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="{{ route('logout') }}"  onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" >
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>        

    @endguest
    
</nav>
