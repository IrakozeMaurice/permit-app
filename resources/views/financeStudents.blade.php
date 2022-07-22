@include('partials.finance-header')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Registered students</h1>
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
                  <th class="text-center">Email</th>
                  <th class="text-center">Amount due</th>
                  <th class="text-center">Amount paid</th>
                  <th class="text-center">Remaining</th>
                  <th class="text-center">Percentage</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($charges as $charge)
                  <tr @if ($charge->amount_due < 50000) class="bg-success text-dark" @endif>
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

@include('partials.finance-footer')