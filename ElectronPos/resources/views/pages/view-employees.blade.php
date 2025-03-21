<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
        <script>
            $(document).ready(function () {

                //search the customers
                $("#searchInput").on("keyup", function () {
                 var value = $(this).val().toLowerCase();   
                 console.log(value);     
                $("#employeesTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                });

                $("#exportCustomers").on("click", function () {
                    // Clone the printable content
                    var customersTable = $("#customersTable").clone();
        
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    customersTable.find("button, input").remove();
        
                    // Remove specific columns (edit and delete) from the cloned table
                    customersTable.find('th:nth-child(n+6), td:nth-child(n+6)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(customersTable[0], {
                        margin: 10,
                        filename: 'EmployeesList.pdf',
                        jsPDF: { 
                            orientation: 'landscape' 
                        }
                    });
                });
            });
        </script>
        <div class="container-fluid py-4">
            @if(session('success'))
            <script>
            Swal.fire({
                icon: 'success',
                position: "top-end",
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1000 // Adjust the timer as needed
            });
            </script>
            @endif
            
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Employees</h6>
                                    <h6 class="text-white text-capitalize ps-3">Number Of Employees {{$employeesCount}} </h6>
                                </div>
                                <hr>
                                <a class="btn btn-danger" href="{{ route('create-employee') }}"
                                            role="tab" aria-selected="true">
                                            <i class="material-icons text-lg position-relative"></i>
                                            <span class="ms-1">Create New Employee</span>
                                </a>
                            </div>
                        </div>
                        <div>
                            <input type="text" id="searchInput" class="form-control border border-2 p-2" placeholder="Search Employee...">
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center" id="employeesTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 150px;">
                                               Employee Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 150px;">
                                                Pos Username
                                             </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                               Email
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Phone
                                             </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                              Role
                                            </th>                                            
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Delete
                                             </th>
                                             <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Edit
                                             </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$employee->name}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$employee->pos_username}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$employee->email}}</h6>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$employee->created_at}}</h6>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$employee->role}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('delete-employee',$employee->id) }}">Delete Employee</a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('edit-employee',$employee->id) }}">Edit Employee</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$employees->links()}}                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
