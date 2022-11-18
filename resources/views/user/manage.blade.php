<x-layout>
    <x-general-card>
        <div class="table">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>User <b>Management</b></h2>
                        </div>
                        <div class="col-sm-7">
                            <button type="button" class="btn btn-primary" data-bs-target="#addUserModal" data-bs-toggle="modal">
                                <span>
                                    New
                                </span>
                            </button>				
                        </div>
                    </div>
                </div>
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
                        @unless($user->isEmpty())
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
                                <td class="col-1">
                                    <span class="status text-success">
                                        &bull;
                                    </span> 
                                    Active
                                </td>
                                <td class="col-2 justify-self-end">
                                    <div class="dropdown">
                                        <button class="btn bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
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
                        @else
                            <tr>
                                <td> User is empty. </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>
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