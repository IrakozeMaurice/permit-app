@section('extra-css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
@endsection
@section('extra-js')
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@section('username')
  {{ $student->names }}
@endsection
<x-app-layout>
  <x-slot name="header">
  </x-slot>
  <div class="py-12">
    <div class="row">
      <div class="col-md-4">
        <h5 class="pl-4">Student Id: <span
            class="badge badge-pill badge-success">{{ $student->student_id }}</span></h5>
      </div>
      <div class="col-md-6">
        <h5>Student names: <span
            class="badge badge-pill badge-primary">{{ $student->names }}</span>
        </h5>
      </div>
      @if(!empty($registration))
      <div class="col-md-2">{{ $charge->percentage >= 100 ? 'PAID FULL' : $charge->percentage . '% PAID' }}</div>
    </div>
    @if (session('message'))
      <div class="alert alert-success">
        <h5 class="text-center">{{ session('message') }}</h5>
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">
        <h5 class="text-center">{{ session('error') }}</h5>
      </div>
    @endif
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#home">Submit bank slip</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu1">Registration Form</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu2">Payment Summary</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu3">Exam permit</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu4">Contract of payment</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content mt-6">
            <div class="tab-pane active container" id="home">
              <div class="text-center mt-4" style="width: 60%;margin:auto;">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                @if (session('success'))
                  <div class="alert alert-success">
                    <h5 class="text-center">{{ session('success') }}</h5>
                  </div>
                @endif
                @if (session('error'))
                  <div class="alert alert-danger">
                    <h5 class="text-center">{{ session('error') }}</h5>
                  </div>
                @endif
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <h5 class="mt-4 text-center">Submit your bank slip</h5>
                  <hr>
                  <div class="form-group">
                    <input type="number" class="form-control" name="amount" placeholder="amount paid"
                      required>
                  </div>
                  <div class="form-group">
                    <textarea name="comment" class="form-control" rows="3" placeholder="comment" required></textarea>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="ref_number" placeholder="reference number"
                      required>
                  </div>
                  <div class="form-group">
                    <label for="bank_slip"><small><b>Attach your bank slip</b></small></label>
                    <input type="file" class="form-control" name="bank_slip" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="tab-pane container fade" id="menu1">
                <h5 class="mt-4 text-center">Registration Form</h5>
                <hr>
                <div style="width: 80%;margin:auto;font-size: 14px;">
                  <div class="row">
                    <div class="col-md-6 text-left">
                      <p>Student Number: {{ $student->student_id }}</p>
                      <p>Student Names: {{ $student->names }}</p>
                    </div>
                    <div class="col-md-6 text-right">
                      <p>Faculty: {{ $faculty->name }}</p>
                      <p>Department: {{ $department->name }}</p>
                        <p>Program: {{ $registration->program }}</p>
                    </div>
                  </div>
                  <hr>
                  <table class="table table-borderless text-center">
                    <thead>
                      <tr>
                        <th>CODE</th>
                        <th>COURSE DESCRIPTION</th>
                        <th>CREDITS</th>
                        <th>GROUP</th>
                        <th>COST/Cr</th>
                        <th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($courses as $course)
                        <tr>
                          <td>{{ $course->code }}</td>
                          <td>{{ $course->name }}</td>
                          <td>{{ $course->credits }}</td>
                          <td>{{ $group }}</td>
                          <td>{{ number_format($creditCost, 0, null, ',') }}</td>
                          <td>{{ number_format($creditCost * $course->credits, 0, null, ',') }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <hr>
                  <p class="text-center">Total credits: {{ $totalCredits }}</p>
                </div>
                <div style="width: 50%;margin:auto;border:1px solid black;">
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Registration Fee: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($otherFees['registrationFee'], 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Late Fine: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($otherFees['lateFineFee'], 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Facility Fee: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($otherFees['facilityFee'], 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Research Manual: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($otherFees['researchManualFee'], 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Student Card: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($otherFees['studentCardFee'], 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Graduation Fee: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($otherFees['graduationFee'], 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Library Card Fee: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($otherFees['libraryCardFee'], 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Sanitation Fee: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($otherFees['sanitationFee'], 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4">Tuition Fee: </span>
                    </div>
                    <div class="col-sm-6">
                      <span>{{ number_format($tuitionFee, 0, null, ',') }}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pl-4"><b>TOTAL TO BE PAID: </b></span>
                    </div>
                    <div class="col-sm-6">
                      <span><b>{{ number_format($totalFee, 0, null, ',') }}</b></span>
                    </div>
                  </div>
                </div>
            </div>
            <hr>
            <div class="tab-pane container fade" id="menu2">
              {{-- Payment Summary --}}
                <div class="row">
                  <div class="col-lg-6">
                    <h1 class="h4 lead text-gray-800">Payment Summary</h1>
                    <hr>
                    <small>Student charges for semester {{ $registration->semester }}
                      {{ $registrationYear }}:&nbsp;&nbsp;
                      <b><u>{{ number_format($charge->total_charges, 0, null, ',') }}</u></b></small><br>
                    <small>Amount paid: {{ number_format($charge->amount_paid, 0, null, ',') }}</small><br>
                    <small>Amount due: {{ number_format($charge->amount_due, 0, null, ',') }}</small><br>
                    <br>
                    <hr>
                  </div>
                  <div class="col-lg-6">
                    <h1 class="h4 lead text-gray-800">Payment History</h1>
                    <hr>
                    @forelse ($payments as $payment)
                      <small>Payment date: {{ $payment->created_at }}&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</small>
                      <small>Amount paid: {{ number_format($payment->amount, 0, null, ',') }} Frw</small>
                      @if($payment->accepted)
                      <span class="badge badge-pill badge-success">accepted</span>
                      @elseif($payment->declined)
                      <span class="badge badge-pill badge-danger">declined</span>
                      @else
                      <span class="badge badge-pill badge-info">pending</span>
                      @endif
                      <br>
                      <hr>
                    @empty
                      <p class="jumbotron text-center text-danger">No payments found for this account.</p>
                    @endforelse
                  </div>
                </div>
            </div>
            <div class="tab-pane container fade" id="menu3">
              <div class="jumbotron text-center">
                @if ($permitReleased)
                <div style="width:40%;margin: auto;">
                  @if($charge->percentage >= 90)
                    <h5 class="text-center">Adventist University of Central Africa</h5>
                    <h5 class="text-center"><b><u>Exam Permit</u></b></h5>
                    <p class="text-center">Semester {{$registration->semester}} {{$registrationYear}} | Final Exam</p>
                    <p style="text-align: left;"><b>Student Id N<sup>o</sup>: {{$student->student_id}}</b></p>
                    <p style="text-align: left;"><b>Student Name: {{$student->names}}</b></p>
                    <table class="table table-bordered">
                      <tr>
                        <th>#</th>
                        <th>Course Title(code)</th>
                        <th>Answer Booklet No</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td></td>
                        <td></td>
                      </tr>
                    </table>
                </div>
                      <a href="{{route('dashboard.permit.pdf')}}" class="btn btn-sm btn-primary">Download permit</a>
                    @else
                      <p>exam permit not avalaible. <span class="text-danger">MISSING REQUIREMENTS</span></p>
                    @endif
                  @else
                    <p>exam permit not available. <span class="text-danger">PERMIT CARDS HAVE NOT BEEN RELEASE YET.</span></p>
                  @endif
              </div>
            </div>
            <div class="tab-pane container fade" id="menu4">
              <div class="jumbotron text-center">
              @if ($contract)
              <h5 class="text-center">Contract of payment</h5>
              <hr>
              <div class="row">
                <div class="col-md-6"><p>Student id: {{$student->student_id}}</p></div>
                <div class="col-md-6">Student names: {{$student->names}}</div>
              </div>
              <table id="tableSearch" class="table table-bordered table-hover text-center">
                <thead>
                  <tr>
                    <th class="text-center">Amount Total to be paid</th>
                    <th class="text-center">Paymnet made</th>
                    <th class="text-center">Remain</th>
                    <th class="text-center">{{$date1}}</th>
                    <th class="text-center">{{$date2}}</th>
                    <th class="text-center">{{$date3}}</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>{{ number_format($contract->total_to_be_paid, 0, null, ',') }}</td>
                      <td>{{ number_format($contract->payment_made, 0, null, ',') }}</td>
                      <td>{{ number_format($contract->remain, 0, null, ',') }}</td>
                      <td>{{ number_format($contract->installment_one, 0, null, ',') }}</td>
                      <td>{{ number_format($contract->installment_two, 0, null, ',') }}</td>
                      <td>{{ number_format($contract->installment_three, 0, null, ',') }}</td>
                    </tr>
                </tbody>
              </table>
              <div class="row">
                <p class="pl-3">That i <u>{{$student->names}}</u> hereby acknowledge that as of <u>{{$date}}</u> , I registered with the Adventist university of central africa</p>
                <p class="pl-3">with <u>{{$totalCredits}}</u> credits and i promise to pay the total amount of fees on installment payment at the date as specified above.</p>
                <p class="pl-3">That i accept and fully understand that tuition and fees paid upon registration is not refundable on whatever reason and that</p>
                <p class="pl-3"><b>5%</b> penalty per month on the amount due will be charged on delayed payment.</p>
                <br><br>
              </div>
              <br>
              @if($contract->signed)
              <p class="pl-3">
                <a href="{{route('dashboard.contract.pdf')}}" class="btn btn-sm btn-primary">Download contract</a>
              </p>
              @else
              <p class="pl-3">
              <a href="{{route('dashboard.sign-contract')}}" class="btn btn-sm btn-success">Sign contract</a>
              </p>
              @endif
              @else
              @if($canClaim && $charge->percentage < 100)
              <a href="{{route('dashboard.claim-contract')}}" class="btn btn-sm btn-primary">claim late of contract</a>
              @elseif($charge->percentage >= 100)
              <p>No contract available. <span class="text-success">YOU HAVE PAID THE FULL AMOUNT</span></p>
              @else
              <p>No contract available. <span class="text-info">NO PAYMENTS MADE/ACCEPTED YET</span></p>
              @endif
              @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    @else
      <hr>
      <div style="width: 80%;margin:auto;">
        <div class="jumbotron text-center">
          <p class="text-danger">No registration form found</p>
          <h5>Register courses to use this application</h5>
        </div>
        <hr>
      </div>
    @endif
      <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
        <div class="text-center text-sm text-gray-500 sm:text-left">
          <div class="flex items-center">
            <span>Made with</span>
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"
              viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 text-gray-400">
              <path
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
              </path>
            </svg>
            <span>&nbsp;&nbsp;&nbsp;&nbsp;By&nbsp;</span>
            <a href="https://github.com" class="ml-1 underline">
              Steven MUGARA
            </a>
          </div>
        </div>
        <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
          Auca@2022
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
