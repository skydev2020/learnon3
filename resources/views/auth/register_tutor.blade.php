@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Register Tutors') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register_tutor') }}" onsubmit="return submitOnValid()">
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
                                    <?php use App\State;
                                    $states = State::all();
                                    ?>
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
                                    <?php use App\Country;
                                    $countries = Country::all();
                                    ?>
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

                        <h4 style="text-align: center">{{ __('Other Details') }}</h4>

                        <div class="form-group row col-12">
                            <label for = "other_notes" class="font-weight-bold">{{ __('Other Notes') }}</label>
                            <textarea class="form-control inputstl" id = "other_notes" name = "other_notes"  value="{{ old('other_notes') }}"
                            required autocomplete="other_notes" autofocus>
                            </textarea>
                        </div>


                        <div class="form-group row col-12">
                            <label for = "post_secondary_edu" class="font-weight-bold">{{ __('Post Secondary Education attending/attended') }}</label>
                            <textarea class="form-control inputstl" id = "post_secondary_edu" name = "post_secondary_edu"  value="{{ old('post_secondary_edu') }}"
                            required autocomplete="post_secondary_edu" autofocus>
                            </textarea>
                        </div>

                        <div class="form-group row col-12">
                            <label for = "area_of_concentration" class="font-weight-bold">
                            {{ __('Subjects studied/major area of concentration (please indicate grades and grade point averages)') }}
                            </label>
                            <textarea class="form-control inputstl" id = "area_of_concentration" name = "area_of_concentration"  value="{{ old('area_of_concentration') }}"
                            required autocomplete="area_of_concentration" autofocus>
                            </textarea>
                        </div>

                        <div class="form-group row col-12">
                            <label for = "tutoring_courses" class="font-weight-bold">
                            {{ __('Courses you can tutor for each grade level (list each course, please be as detailed as possible)') }}
                            </label>
                            <textarea class="form-control inputstl" id = "tutoring_courses" name = "tutoring_courses"
                              value="{{ old('tutoring_courses') }}"
                            required autocomplete="tutoring_courses" autofocus>
                            </textarea>
                        </div>

                        <div class="form-group row col-12">
                            <label for = "work_experience" class="font-weight-bold">{{ __('Please provide past job/work experience(N/A for none)') }}</label>
                            <textarea class="form-control inputstl" id = "work_experience" name = "work_experience"
                              value="{{ old('work_experience') }}"
                            required autocomplete="work_experience" autofocus>
                            </textarea>
                        </div>

                        <div class="form-group row col-12">
                            <label for = "tutoring_areas" class="font-weight-bold">{{ __('City/suburbs/area you can tutor') }}</label>
                            <textarea class="form-control inputstl" id = "tutoring_areas" name = "tutoring_areas"
                              value="{{ old('tutoring_areas') }}"
                            required autocomplete="tutoring_areas" autofocus>
                            </textarea>
                        </div>

                        <div class="form-group col-md-4 row">
                            <label for = "sex_val" class="font-weight-bold">Please indicate Male/Female</label>
                            <select name="sex_val" style="display: block;" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="form-group col-12 row">
                            <label class="font-weight-bold">Are you a certified teacher?&nbsp; &nbsp;</label>
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="certified" value="Yes">&nbsp;Yes
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="certified" value="No">&nbsp;No
                            </label>
                        </div>

                        <div class="form-group col-12 row">
                            <label class="font-weight-bold">Have you ever had a criminal conviction (disregarding minor traffic violations)?&nbsp; &nbsp; </label>
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cr_radio" value="Yes">&nbsp;Yes
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cr_radio" value="No">&nbsp;No
                            </label>
                        </div>

                        <div class="form-group col-12 row">
                            <label class="font-weight-bold" >Would you be willing to provide a background criminal check? &nbsp; &nbsp;</label>
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cc_radio" value="Yes">&nbsp;Yes
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cc_radio" value="No">&nbsp;No
                            </label>
                        </div>

                        <div class="form-group row">
                            <h1 style="text-align: center">Independent Contractor - Tutor Agreement</h1>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <b>By becoming a LearnOn! tutor I, </b><input type="text" name="name1" id="name1" > (fill in first last name and have it be the exact same as you filled in the boxes of the first page) <b>agree to the following Terms & Conditions.</b>
                                <br>
                                <br>
                                <b>1. The terms and/or conditions in this agreement can not and will not be interpreted for any reason as the establishment of an employer/employee relationship. I understand that as an independent contractor, I will not be an employee of LearnOn! Tutoring and will not be entitled to participate in or to receive any benefits or rights from LearnOn! Tutoring’s employment benefits or welfare plans including but not limited to any pension plans, health plans, disability insurance, and workers compensation insurance. </b>
                                <br>
                                <br>
                                <b><span style="color: red">2. I must refuse direct payment by the student, their parents or guardians, LearnOn! will pay me for the tutoring services that I provide. </span></b>
                                <br>
                                <br>
                                <b>3. I am responsible for behaving in a professional manner at all times and will be held personally accountable for any inappropriate, illegal or questionable behavior. </b>
                                <br>
                                <br>
                                <b>4. LearnOn! is not liable for any damages, which occur to my person or property as a result of LearnOn! tutoring sessions, and I absolve LearnOn! of any liability by entering into this agreement.  </b>
                                <br>
                                <br>
                                <b>5. I understand that all company and client information is strictly confidential and distribution is strictly prohibited. </b>
                                <br>
                                <br>
                                <b>6. I understand that in order for parents and students to feel comfortable having me in their home I must follow a certain code of conduct. This includes being prepared, being on time, being polite and personable, and arriving properly dressed. </b>
                                <br>
                                <br>
                                <b>7. I am responsible for submitting my tutoring hours online accurately by the end of each calendar month using the LearnOn! online logging system, this is how I invoice LearnOn! for the services I have provided. I am also responsible for responding to all LearnOn! administration calls/emails pertaining to my students within 24 hours. </b>
                                <br>
                                <br>
                                <b>8. LearnOn! tutors are prohibited to make direct tutoring arrangements with LearnOn! clients while being under contract with LearnOn! and for a period of two (2) years after contract is terminated. </b>
                                <br>
                                <br>
                                <b>9. I agree that students, client, referrals and leads to prospective students belong to LearnOn! Tutoring. I agree that any breach of this provision may be considered theft of property and may result in legal action against me, and regardless of the outcome, I will reimburse LearnOn! Tutoring for all legal and administrative expenses incurred by LearnOn! Tutoring. </b>
                                <br>
                                <br>
                                <b>10. I may be presented at any time with a "mystery client" commissioned by LearnOn! to verify that I am complying with the Tutor Agreement. </b>
                                <br>
                                <br>
                                <b>11. I will be paid during the second half of the calendar month following the month in which I provided my service. My fee will be based on the tutor posting or the amount agreed upon with LearnOn! for that particular session.  </b>
                                <br>
                                <br>
                                <b>12. I understand that I will not be paid if I signed up for a session that I was not prepared for nor had sufficient knowledge to conduct and therefore was not done to the satisfaction of the student.  This does not mean, that if the student has bad grades after ongoing tutoring it is a reflection of my work.  It means that I will not sign up for a session, I know nothing about.  The students grades are not your responsibility and will not impact your pay after ongoing tutoring. </b>
                                <br>
                                <br>
                                <b>13. LearnOn! Tutoring shall not be liable for any expenses paid or incurred by myself unless otherwise agreed to ahead of time in writing. </b>
                                <br>
                                <br>
                                <b>14. I have no authority to enter into contracts or agreement on behalf of LearnOn! Tutoring. </b>
                                <br>
                                <br>
                                <b>15. I represent that I am in good mental and physical health and free from communicable diseases. If at any time, the state of my health may harm that of any LearnOn! Tutoring’s clients, I must report such change to LearnOn! Tutoring. </b>
                                <br>
                                <br>
                                <b>16. I certify that I do not have a criminal record and I have never been convicted of any crime.  </b>
                                <br>
                                <br>
                                <b>17. I certify that I have NEVER been charged with any sex-related or child abuse related offences and herby authorize LearnOn! Tutoring to run a background check on me with whatever authorities Learn On! Tutoring deems convenient, including but not limited to criminal records. </b>
                                <br>
                                <br>
                                <b>18. I absolve LearnOn! Tutoring for liability, actions or claims for any damages, in all areas of law, including but not limited to criminal, tort, contract, property and others. </b>
                                <br>
                                <br>
                                <b>19. I will refuse to be left unaccompanied with any student under the age of 16. I agree to indemnify and hold LearnOn! Tutoring harmless from any losses, liabilities damages, expenses, claims, and/or from failure to abide by any Federal, State/Provincial or Local law relating to my services.  </b>
                                <br>
                                <br>
                                <b>20. I understand that as an independent contractor no income tax, payroll tax or any form of government payments will be withheld or paid by LearnOn! Tutoring on behalf of me and therefore I am responsible for reporting my earnings and I am responsible for any income tax that must be paid.  </b>
                                <br>
                                <br>
                                <b>21. I am liable for all costs, expenses and expenditures including, and without limitation, the complete legal costs incurred by LearnOn! in enforcing this agreement as a result of any default of this Agreement by the tutor.  </b>
                                <br>
                                <br>
                                <b>I    </b></b><input type="text" name="name2" id="name2" required > (fill in first last name and have it be the exact same as you filled in the boxes of the first page)<b>understand that stealing student or clients, tutoring and not reporting hours, or receiving payment directly from students/parents is strictly prohibited and will result in legal action being taken against me. I also agree that if legal action is taken due to this breach in policy that I will be responsible for reimbursement of legal charges, incurred by LearnOn! Tutoring. This includes all expenses for all legal proceedings related to the charges and any and all attempts to collect a debt.</b>
                                <br>
                                <br>
                                <b>I    </b></b><input type="text" name="name3" id="name3" required >(fill in first last name and have it be the exact same as you filled in the boxes of the first page)<b>have carefully read, and fully understand all of the above Terms and Conditions.</b>
                            </div>
                        </div>


                        <div class="row" id="btn_dsp" style="text-align: center;" >
                            <div class="form-group col-12" >
                            <span style="color: red;display: none;" id="dup_email_prob"><b>Email already Exists !</b></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group col-8 text-right" >
                                <input type="checkbox" name="terms_val" id ="terms_val" required onclick="checkName()"> I have read and agree to the <b>Terms & Conditions</b>
                                <b><span id="tcmessage" class="confirmMessage"></span><b>
                                <br>
                                <span style="color: red; display: none;" id="name_match"><b>All the Names are not maching correctly.</b></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-4">
                                <button type="submit" class="btn btn-primary" id = "register" disabled>
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
<script src="{{ asset('js/register/register_tutor.js')}}"></script>
@stop
