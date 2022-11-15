<x-layout>
    <div class="container-xl mt-5">
        <div class="table">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>User <b>Management</b></h2>
                        </div>
                        <div class="col-sm-7">
                            <a href="#" class="btn btn-secondary"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
                            <a href="#" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></a>						
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>						
                            <th>Date Created</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
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
                                <td>{{-- {{$det->created_at}} --}}</td>                        
                                <td>{{ucfirst($det->role())}}</td>
                                <td><span class="status text-success">&bull;</span> Active</td>
                                <td>
                                    <a href="#" class="settings" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                                    <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td> User is empty. </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>
                <div class="clearfix">
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
                </div>
            </div>
        </div>
    </div>     
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