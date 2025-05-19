<header>
    <div class="header_container">
<img src="{{ asset('images/logo1.png') }}" alt="Logo" class="logo">
 <div class="logoutcontainer">
                <a href='{{route('create')}}' class='create btn'>Add New</a>
               <a href="{{route('getStudentData')}}" class="table_view table_btn" >View Details</a>
             <a href="{{route('logout')}}" class='logout btn'>Logout</a>
    </div>
</div>           
</header>