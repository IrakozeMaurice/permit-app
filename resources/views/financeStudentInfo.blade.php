@include('partials.finance-header')
          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-6">
              <h4>Student Name: <span class="text-info">{{ $student->names }}</span></h4>
              <h4>Student Id: <span class="text-info">{{ $student->studentId }}</span></h4>
              <h4>Email: <span class="text-info">{{ $student->email }}</span></h4>
              <br>
            </div>
            {{-- <div class="col-lg-6">
              <h3>Balance: <span class="text-success mt-4">{{ number_format($account->balance, 0, null, ',') }}
                  Rwf</span></h3>
            </div> --}}
          </div>
          <hr>
          <div class="row">
            <div class="col-lg-6">
              <h1 class="h4 lead text-gray-800">Payments information</h1>
              <hr>
              @forelse ($student->payments as $payment)
                <small>Date: {{ $payment->paymentDate }}</small><br>
                <small>Amount: {{ $payment->amount }}</small><br>
                <small>Comment: {{ $payment->comment }}</small><br>
                <small>Bankslip:</small>
                <a href="{{asset('files/'. $payment->bank_slip)}}" target="_blank" class="text-primary">{{ $payment->bank_slip }}</a>
                <br>
                <hr>
              @empty
                <div class="jumbotron text-center">
                  <h4>No payment made so far.</h4>
                </div>
              @endforelse
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

@include('partials.finance-footer')