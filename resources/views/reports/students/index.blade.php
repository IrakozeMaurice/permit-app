<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Online school fees payment</title>
  <!-- Custom fonts for this template-->
  <link
    href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}"
    rel="stylesheet"
    type="text/css" />
  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul
      class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
      id="accordionSidebar">
      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('finance.dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider" />
      <!-- Heading -->
      <div class="sidebar-heading">Interface</div>
      <!-- Nav Item - Registered students -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('finance.students') }}">
          <i class="fas fa-fw fa-users"></i>
          <span>Registered students</span></a>
      </li>
      <!-- Nav Item - Payments -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('finance.payments') }}">
          <i class="fas fa-fw fa-table"></i>
          <span>Payments</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block" />
      <!-- Nav Item - Reports Collapse Menu -->
      <li class="nav-item">
        <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseTwo"
          aria-expanded="true"
          aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Reports</span>
        </a>
        <div
          id="collapseTwo"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Generate reports:</h6>
            <a class="collapse-item" href="{{ route('reports.students') }}">Students</a>
            {{-- <a class="collapse-item" href="{{ route('reports.payments') }}">Payments</a> --}}
          </div>
        </div>
      </li>
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav
          class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- Sidebar Toggle (Topbar) -->
          <button
            id="sidebarToggleTop"
            class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <a
            href="#"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Time: {{ $time }}</a>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="userDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                <img
                  class="img-profile rounded-circle"
                  src="{{ asset('img/undraw_profile.svg') }}" />
              </a>
              <!-- Dropdown - User Information -->
              <div
                class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a href="{{ route('finance.logout') }}" class="dropdown-item">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Reports | Students</h1>
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
              <a href="#" class=""><img
                  src="{{ asset('images/aucaLogo.png') }}"
                  alt="Auca logo"></a>
            </div>
          </div>
          <!-- Content Row -->
          <div class="row">
            <div class="col-md-9">
              <form action="{{ route('reports.students.filter') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Amount paid percentage</label>
                  <select class="form-control" name="percentagePaid" style="display:inline-block; width:30%;">
                    <option value="50">50%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="100">100%</option>
                  </select>
                  <x-button class="ml-3">
                    Go
                  </x-button>
                </div>
              </form>
            </div>
            <div class="col-md-3">
              <a href="{{ route('reports.students.pdf') }}" class="btn btn-sm btn-primary">Export to pdf</a>
            </div>
          </div>
          <div class="row">
            <table id="tableSearch" class="table table-bordered table-hover text-center">
              <thead>
                <tr>
                  <th class="text-center">Student Id</th>
                  <th class="text-center">Names</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Amount due</th>
                  <th class="text-center">Amount paid</th>
                  <th class="text-center">Remaining</th>
                  <th class="text-center">Percentage</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($charges as $charge)
                  <tr @if ($charge->percentage >= 100) class="bg-success text-dark" @endif>
                    <td><a href="{{ route('finance.studentInfo', ['student' => $charge->student]) }}"
                        style="color: blue;">{{ $charge->student->studentId }}</td>
                    <td>{{ $charge->student->names }}</td>
                    <td>{{ $charge->student->email }}</td>
                    <td>{{ $charge->total_charges }}</td>
                    <td>{{ $charge->amount_paid }}</td>
                    <td>{{ $charge->amount_due }}</td>
                    <td><b class="text-dark">{{ $charge->percentage }} %</b></td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th class="text-center"></th>
                  <th class="text-center"></th>
                  <th class="text-center"></th>
                  <th class="text-center"></th>
                  <th class="text-center"></th>
                  <th class="text-center"></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
            <div class="text-center text-sm text-gray-500 sm:text-left">
              <div class="flex items-center">
                <span>Made with</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                  <path
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                  </path>
                </svg>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;By&nbsp;</span>
                <a href="https://github.com/asokaniyonsaba" class="ml-1 underline">
                  Asoka Niyonsaba
                </a>
              </div>
            </div>
            <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
              Auca@2022
            </div>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
  <!-- Page level plugins -->
  <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
  <!-- Page level custom scripts -->
  <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
  @include('partials.datePickerScript')
</body>

</html>
