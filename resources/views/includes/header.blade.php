<header>
    <nav class="navbar navbar-expand-lg navbar-light"style="background-color: #385d7a">
        <a class="navbar-brand" href="{{ route('dashboard') }}" ><span>Magazin</span></a>
        <img src="{{URL::to('images/h-bayrak.gif')}}" height="50px" width="200px">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a href="{{route('account')}}" class="nav-link"> Profile <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link"> logout <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

</header>


