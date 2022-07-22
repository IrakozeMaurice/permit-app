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
                  <th class="text-center">Amount</th>
                  <th class="text-center">Payment Date</th>
                  <th class="text-center">Comment</th>
                  <th class="text-center">Bankslip</th>
                  <th class="text-center">Ref No</th>
                  <th class="text-center">Action/Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($payments as $payment)
                  <tr class="clickable-row">
                    <td class="text-primary"><a href="#">{{ $payment->student->studentId }}</td>
                    <td>{{ $payment->student->names }}</td>
                    <td>{{ number_format($payment->amount, 0, null, ',') }}</td>
                    <td>{{ $payment->paymentDate }}</td>
                    <td>{{ $payment->comment }}</td>
                    <td class="text-primary"><a href="{{asset('files/'. $payment->bank_slip)}}" target="_blank">{{ $payment->bank_slip }}</a></td>
                    <td>{{ $payment->ref_number }}</td>
                    <td>
                        @if(!$payment->accepted && !$payment->declined)
                        <form style="display:inline;" action="{{route('finance.payments.approve',$payment->id)}}" method="POST">
                        @csrf
                          <button type="submit" class="btn btn-sm bg-info text-white">Accept</button>
                        </form>
                        <form style="display:inline;" action="{{route('finance.payments.decline',$payment->id)}}" method="POST">
                        @csrf
                          <button type="submit" class="btn btn-sm bg-danger text-white">Decline</button>
                        </form>
                        @endif
                        @if($payment->accepted)
                          <span class="badge badge-pill badge-success badge-large">Accepted</span>
                        @endif
                        @if($payment->declined)
                          <span class="badge badge-pill badge-danger badge-large">Declined</span>
                        @endif
                      </td>
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