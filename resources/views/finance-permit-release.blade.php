@include('partials.finance-header')
          <!-- Content Row -->
          <div style="width:40%; margin: auto; background: #eee; padding: 20px; text-align: center;">
            <h3 class="h3 mb-0 text-gray-800">Set permit release date</h3><br><hr><br>
            @if (session('message'))
              <br>
              <div class="alert alert-success">
                <p class="text-center">{{ session('message') }}</p>
              </div>
              <br>
            @endif
            <form action="{{route('finance.dashboard.release-permit')}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="release-date"><small><b>select date</b></small></label>
                @error('release-date')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <input type="date" name="release-date" class="form-control" required>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-sm bg-primary text-white">Update</button>
              </div>
            </form>
            <br>
            <hr>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      @include('partials.finance-footer')