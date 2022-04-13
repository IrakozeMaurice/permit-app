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
            <h1 class="h3 mb-0 text-gray-800">Payments</h1>
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
              <a href="#" class=""><img
                  src="{{ asset('images/aucaLogo.png') }}"
                  alt="Auca logo"></a>
            </div>
          </div>
          <hr>
          <!-- Content Row -->
          <div class="row">
            <table id="tableSearch" class="table table-bordered table-hover text-center">
              <thead>
                <tr>
                  <th class="text-center">Student Id</th>
                  <th class="text-center">Names</th>
                  <th class="text-center">Amount</th>
                  <th class="text-center">Payment Date</th>
                  <th class="text-center">Comment</th>
                  <th class="text-center">Bankslip Number</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($payments as $payment)
                  <tr>
                    <td><a style="color: forestgreen;" href="#">{{ $payment->student_id }}</td>
                    <td>{{ $payment->student->names }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->paymentDate }}</td>
                    <td>{{ $payment->comment }}</td>
                    <td>{{ $payment->bank_slip_number }}</td>
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
</body>

</html>
