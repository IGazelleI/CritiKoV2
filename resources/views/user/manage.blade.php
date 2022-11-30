<x-layout>
    <x-general-card>
        <div class="table">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>
                                {{currentSelected($type)}}
                                <b>Management</b>
                            </h2>
                        </div>
                        <div class="col">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-bs-target="#addUserModal" data-bs-toggle="modal">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                                        </svg>
                                    </span>
                                </button>
                                <a href="{{route('user.manage',1)}}"  class="btn btn-warning">Admin</a>
                                <a href="{{route('user.manage',2)}}" class="btn btn-light">SAST</a>
                                <a href="{{route('user.manage',5)}}" class="btn btn-info">Dean</a>
                                <a href="{{route('user.manage',3)}}" class="btn btn-success">Faculty</a>
                                <a href="{{route('user.manage',4)}}" class="btn btn-danger">Student</a>
                                <a href="{{route('user.manage')}}" class="btn btn-dark">All</a>
                            </div>
                        </div>
                    </div>
                </div>
                @unless($user->isEmpty())
                
                @if($type != 5)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th colspan="2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $det)
                        <tr>
                            <td>{{$det->id}}</td>
                            <td>
                                <a href="#">
                                    <img src="{{getAvatar($det)}}" class="img-fluid img-thumbnail rounded-circle" alt="Avatar" style="width: 5%">
                                    {{$det->email}}
                                </a>
                            </td>
                            <td>{{ucfirst($det->role())}}</td>
                            <td class="col-2">
                                <span class="status text-success">
                                    &bull;
                                </span>
                                Active
                            </td>
                            <td class="col-2 justify-self-end">
                                <div class="dropdown">
                                    <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-target="#Modal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                            >
                                                Reset Password
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-target="#Modal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                            >
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Dean</th>
                            <th colspan="2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $det)
                        <tr>
                            <td>{{$det->id}}</td>
                            <td>
                                <a href="#">
                                    <img src="{{getAvatar($det)}}" class="img-fluid img-thumbnail rounded-circle" alt="Avatar" style="width: 5%">
                                    {{$det->department->name}}
                                </a>
                            </td>
                            <td>{{ucfirst($det->fullName(0))}}</td>
                            <td class="col-2">
                                <span class="status text-success">
                                    &bull;
                                </span>
                                Active
                            </td>
                            <td class="col-2 justify-self-end">
                                <div class="dropdown">
                                    <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-target="#Modal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                            >
                                                Reset Password
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-target="#Modal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                            >
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @else
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> {{currentSelected($type)}} is empty </h3>
                @endunless
                {{-- <div class="clearfix">
                    <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                    <ul class="pagination">
                        <li class="page-item disabled"><a href="#">Previous</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item active"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">5</a></li>
                        <li class="page-item"><a href="#" class="page-link">Next</a></li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </x-general-card>
    <x-admin-canvas/>
</x-layout>
@php
    function currentSelected($type)
    {
        switch($type)
        {
            case 1: return 'Admin';
                    break;
            case 2: return 'SAST Officer';
                    break;
            case 3: return 'Faculty';
                    break;
            case 4: return 'Student';
                    break;
            case 5: return 'Dean';
                    break;

            default: return 'User';
        }
    }
    function getAvatar($det)
    {
        $default = 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png';
        switch($det->type)
        {
            case 1: return $default;
                    break;
            case 2: return $default;
                    break;
            case 3: return $default;
                    break;
            case 4: if(isset($det->students[0]->imgPath))
                        return '../' . $det->students[0]->imgPath();
                    else
                        return $default;
                    break;
        }
    }
@endphp
