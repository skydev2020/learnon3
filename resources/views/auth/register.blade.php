@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" onsubmit="return submitOnValid()">
                        @csrf

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="fname" class="col-form-label font-weight-bold">{{ __('First Name') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                                 name="fname" value="{{ old('fname') }}" required autocomplete="fname" autofocus>

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="lname" class="col-form-label font-weight-bold">{{ __('Last Name') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                                 name="lname" value="{{ old('lname') }}" required autocomplete="lname" autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="email" class="col-form-label font-weight-bold">{{ __('E-Mail Address') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" onblur="checkMailStatus()">
                                <span style="color: red; display: none;" id="dup_email_prob"><b>Email already Exists !</b></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="password" class="col-form-label font-weight-bold">{{ __('Password') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="password-confirm" class="col-form-label font-weight-bold">{{ __('Confirm Password') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="home_phone" class="col-form-label font-weight-bold">{{ __('Home phone') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="home_phone" type="text" class="form-control @error('home_phone') is-invalid @enderror"
                                 name="home_phone" value="{{ old('home_phone') }}" required autocomplete="home_phone" autofocus>

                                @error('home_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="cell_phone" class="col-form-label font-weight-bold">{{ __('Cell phone') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="cell_phone" type="text" class="form-control @error('cell_phone') is-invalid @enderror"
                                 name="cell_phone" value="{{ old('cell_phone') }}" required autocomplete="cell_phone" autofocus>

                                @error('cell_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="address" class="col-form-label font-weight-bold">{{ __('Address') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                 name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="city" class="col-form-label font-weight-bold">{{ __('City') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="state_id" class="col-form-label font-weight-bold">{{ __('Province / State') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <select name="state_id" id="state_id">
                                    @foreach($states as $state)
                                    <option value = {{$state->id}}> {{ $state->name }}</option>
                                    @endforeach
                                </select>

                                @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="pcode" class="col-form-label font-weight-bold">{{ __('Pcode') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="pcode" type="text" class="form-control @error('pcode') is-invalid @enderror"
                                 name="pcode" value="{{ old('pcode') }}" required autocomplete="pcode" autofocus>

                                @error('pcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="country_id" class="col-form-label font-weight-bold">{{ __('Country') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <select name="country_id" id="country_id">
                                    @foreach($countries as $country)
                                    <option value = {{$country->id}} > {{ $country->name }}</option>
                                    @endforeach
                                </select>

                                @error('country_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="grade_id" class="col-form-label font-weight-bold">{{ __('Current Grade / Year') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <select name="grade_id" id="grade_id" onchange="getSubjects(this.value);">
                                    @foreach($grades as $grade)
                                    <option value = {{$grade->id}} > {{ $grade->name }}</option>
                                    @endforeach
                                </select>

                                @error('grade_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <label class="col-form-label font-weight-bold">{{ __('Subjects') }}:</label>
                            </div>

                            <div class="col-6 d-flex flex-column">
                                <div class="scrollbox pl-1 pt-1" id="subjects_box" name = "subjects_box">

                                </div>
                                <div>
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="parent_fname" class="col-form-label font-weight-bold">{{ __("Parent's First Name") }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="parent_fname" type="text" class="form-control @error('parent_fname') is-invalid @enderror"
                                 name="parent_fname" value="{{ old('parent_fname') }}" required autocomplete="parent_fname" autofocus>

                                @error('parent_fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="parent_lname" class="col-form-label font-weight-bold">{{ __("Parent's Last Name") }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="parent_lname" type="text" class="form-control @error('parent_lname') is-invalid @enderror"
                                 name="parent_lname" value="{{ old('parent_lname') }}" required autocomplete="parent_lname" autofocus>

                                @error('parent_lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="street" class="col-form-label font-weight-bold">{{ __('Major Street Intersection') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="street" type="text" class="form-control @error('street') is-invalid @enderror"
                                 name="street" value="{{ old('street') }}" required autocomplete="street" autofocus>

                                @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="school" class="col-form-label font-weight-bold">{{ __('School Name') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="school" type="text" class="form-control @error('school') is-invalid @enderror"
                                 name="school" value="{{ old('school') }}" required autocomplete="school" autofocus>

                                @error('school')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="referrer_id" class="col-form-label font-weight-bold">{{ __('How you heard about us') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <select name="referrer_id" id="referrer_id">
                                @foreach($referrers as $referrer)
                                <option value = {{$referrer->id}} > {{ $referrer->name }}</option>
                                @endforeach
                                </select>

                                @error('referrer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="service_method" class="col-form-label font-weight-bold">{{ __('Select Service Method') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <select name="service_method" id="service_method">
                                    <option value = "Online">Online Tutoring</option>
                                    <option value = "Home">In person Tutoring</option>
                                    <option value = "Both">Mix of Both</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <label for="term_val" class="col-form-label font-weight-bold">{{ __('Terms & Conditions') }}</label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                <textarea class="form-control inputstl"  name = "term_val" id="term_val" rows="10"  readonly="">
1. You certify that you are at least 18 years old and that you are the legal guardian of the child/children being registered.
2. If you are not over 18, you MUST have parental permission to sign up for LearnOn! Tutoring.
3. Appointments cancelled with less than 24 hours notice will be billed a minimum of 1 hour/session.
4. Appointments changed to another day can however waive this minimum fee.
5. You are billed at the end of every month for all hours/sessions completed throughout the calendar month. Payment is expected within 7 days.
6. Invoices more than 1 month late will have a $20/month late fee applied for every month that it is late.
7. Tutoring sessions are 60 minutes and you will be billed for a minimum 60 minutes, anything over that is billed at a fraction of the rate.
8. We do NOT offer a money back, first class free, "demo" or "trial" session offer.
9.  There are NO REFUNDS or partial refunds on pre-purchased packages.  We will keep changing tutors until you are happy with one.
10. Tutoring sessions are arranged directly with the LearnOn! office, tutors and clients are not to have ANY contact with each other outside of the prearranged sessions, unless given permission by the office.
11. If you arrange a tutoring session with LearnOn! and fail to appear or be available for the scheduled appointment you will be liable for 1 session of payment.
12. We offer in-home tutoring, however should a tutor, for any reason feel uncomfortable or unsafe at your home he/she can choose to stop going at his/her discretion.
13. Students under the age of 16 should not be left at home alone with the tutor, this is a precautionary measure that should be taken to avoid any possible disputes.
14. Tutoring sessions are paid to LearnOn! and are not to be made to the tutors, we compensate the tutors under already set agreements (please contact us for specific instructions).
15. WE ARE NOT LIABLE FOR ANY DAMAGE (real or imagined), WHICH OCCURS TO A PERSON OR PROPERTY AS A RESULT OR AS A PERCEIVED RESULT OF TUTORING SESSIONS PROVIDED BY LearnOn! By entering into a tutoring agreement with LearnOn! you accept that LearnOn! is not responsible for any damage, loss, theft, or bodily harm that may arise from tutoring sessions arranged with LearnOn! We provide tutors that are trustworthy and responsible, we do checks on them, check with references and take all the precautionary means that are available to us however any issue that arises with an individual tutor must be taken up directly with the tutor and is separate in its entirety from LearnOn!
16. BY ENTERING INTO ANY FORM OF ARRANGEMENT OR AGREEMENT WITH LearnOn!, YOU AGREE TO ABSOLVE LearnOn! FOR LIABILITY, ACTIONS OR CLAIMS FOR ANY DAMAGES, IN ALL AREAS OF LAW, INCLUDING BUT NOT LIMITER TO CRIMINAL, TORT, CONTRACT, PROPERTY AND OTHERS.
17. LearnOn! strives to provide you with the best available tutors and the best academic help possible. We want to help you understand the basics as well as prepare you for exams, however LearnOn! nor any individual tutor will be held accountable or responsible for the academic success or lack thereof demonstrated by the student/client, however we will do everything in our power to help grades/skills improve.
18. YOU the client AGREE that you will NOT solicit any tutor who is assigned to you by LearnOn tutoring for any direct private tutoring services.
19. YOU the client AGREE that you will NOT make direct payment to any tutor and "skip" over LearnOn! Tutoring.
20. If you the client breaks the agreement and makes a direct deal with a tutor assigned to you by LearnOn! Tutoring you are financially liable to LearnOn! Tutoring for all the sessions obtained privately from the tutor. You the client are financially responsible for all legal, collection and court costs that LearnOn! Tutoring incurs in order to enforce this agreement, that includes all lost revenues from paying the tutor directly, soliciting the tutors services privately and skipping over LearnOn! Tutoring.
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group col-12 text-center" >
                                <input type="checkbox" name="terms_val" id ="terms_val" required>I have read and agree to the <b>Terms & Conditions</b>
                                <b><span id="tcmessage" class="confirmMessage"></span><b>
                                <br>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>

                                @error('submit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<!-- Scripts -->
@section("jssection")
<script>
    var grades_json = '<?php echo json_encode($grades_array, JSON_HEX_APOS) ?>';
    var grades = eval(grades_json);

</script>
<script src="{{ asset('js/register/register.js')}}"></script>

@stop
