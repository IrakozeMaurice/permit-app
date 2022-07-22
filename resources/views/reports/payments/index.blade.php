@include('partials.finance-header')
          <!-- Content Row -->
          <div class="row">
            <div class="col-md-9">
              <a href="{{ route('reports.payments.excel') }}" class="btn btn-sm btn-success">Export to Excel</a>&nbsp;&nbsp;&nbsp;
              <a href="{{ route('reports.payments.pdf') }}" class="btn btn-sm btn-primary">Export to pdf</a>
            </div>
          </div>
          <div class="row">
            <table class="table table-bordered table-hover text-center small mt-2">
              <thead>
                <tr>
                  <th class="text-center">Date</th>
                  <th class="text-center">Ref</th>
                  <th class="text-center">Acc</th>
                  <th class="text-center">Names</th>
                  <th class="text-center">Amount</th>
                  <th class="text-center">Deb-Cr</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($payments as $payment)
                  <tr>
                    <td>{{ $payment->Date }}</td>
                    <td>{{ $payment->Ref }}</td>
                    <td>{{ $payment->Acc }}</td>
                    <td>{{ $payment->Names }}</td>
                    <td>{{ $payment->Amount }}</td>
                    <td>{{ $payment->Deb_Cr }}</td>
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
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      @include('partials.finance-footer')