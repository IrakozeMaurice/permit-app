@include('partials.finance-header')
          @if (session('message'))
            <div class="alert alert-success">
              <p class="text-center">{{ session('message') }}</p>
            </div>
          @endif
          <!-- Content Row -->
          <div class="row">
            <table class="table table-bordered text-center small">
              <thead>
                <tr>
                  <th class="text-center">Student Id</th>
                  <th class="text-center">Names</th>
                  <th class="text-center">Claim</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($claims as $claim)
                  <tr class="clickable-row">
                    <td class="text-primary"><a href="#">{{ $claim->student->studentId }}</td>
                    <td>{{ $claim->student->names }}</td>
                    <td>{{ $claim->type }}</td>
                    <td><a href="{{route('finance.dashboard.student-claims',$claim->student->id)}}" class="text-primary"><u>View</u></a></td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
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