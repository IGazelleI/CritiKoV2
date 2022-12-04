<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>CritiKo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet"/>
        <link href="{{asset('assets/css/main.css')}}" rel="stylesheet"/>
    </head>
    <body style="background-color: whitesmoke">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-primary d-none d-lg-block">
            <div class="container-fluid">
                @auth
                <button class="btn btn-transparent shadow-none py-4 ms-n2 my-n2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas{{auth()->user()->role()}}" aria-controls="offcanvasWithBothOptions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-menu-button-wide" viewBox="0 0 16 16">
                        <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h13A1.5 1.5 0 0 1 16 1.5v2A1.5 1.5 0 0 1 14.5 5h-13A1.5 1.5 0 0 1 0 3.5v-2zM1.5 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-13z"/>
                        <path d="M2 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm10.823.323-.396-.396A.25.25 0 0 1 12.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2H1zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2h14zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>
                <img src="{{asset('images/logo.png')}}" class="img-fluid my-n5" style="width: 75px;"/>
                @endauth
                <!-- Navbar brand -->
                <a class="navbar-brand nav-link ms-n4" href="{{route('index')}}">
                    <strong>CritiKo</strong>
                </a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
                    aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse d-flex float-end" id="navbarExample01">
                    <ul class="navbar-nav me-3 mb-2 mb-lg-0 position-absolute d-flex align-items-center end-0">
                        @auth
                        <li>
                            <span class="nav-link mt-4 text-light"> 
                                <b> 
                                    <p style="font-size: 16px">
                                        @if(auth()->user()->type != 3)
                                        {{ucfirst(auth()->user()->role())}}
                                        @else
                                        {{auth()->user()->faculties[0]->isDean? 'Dean' : 'Faculty'}}
                                        @endif
                                        @if(auth()->user()->type == 3)
                                        , 
                                        {{ucfirst(auth()->user()->faculties[0]->fname[0])}}. {{ucfirst(auth()->user()->faculties[0]->lname)}}
                                        @elseif(auth()->user()->type == 4)
                                        , 
                                        {{ucfirst(auth()->user()->students[0]->fname[0])}}. {{ucfirst(auth()->user()->students[0]->lname)}}
                                        @endif
                                    </p>
                                </b> 
                            </span>
                        </li>
                        <li class="nav-link">
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <div class="dropdown-start">
                                    <button class="btn btn-transparent shadow-none text-light ms-n4" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="submit" class="btn bg-transparent rounded shadow-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-power text-danger pe-2" viewBox="0 0 16 16">
                                                    <path d="M7.5 1v7h1V1h-1z"/>
                                                    <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
                                                </svg>
                                                Logout
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar -->
        <!-- MDB -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>
    </body>
    <main>
        {{$slot}}
    </main>
    <footer>
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-center bg-primary fixed-bottom">
          <!-- Copyright -->
          <div class="text-white mb-3 mb-md-0">
            Copyright © 2022. All rights reserved.
          </div>
          <!-- Copyright -->
        </div>
    </footer>
    <x-flash-message/>
</html>
