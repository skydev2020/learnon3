@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header user font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Students</div>

                <div class="card-body">
                    
                    <div class="form-group row">
                        <label for="s_name" class="col-md-4 col-form-label text-md-right">{{ __('User Id:') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __($tutor->email) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Signup Date') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __(date("Y/m/d, $tutor->created_at")) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __($tutor->fname) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __($tutor->lname) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Telephone') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{  __($tutor->home_phone) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Cell/Work Phone') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{  __($tutor->cell_phone) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Home Address') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{  __($tutor->city) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('City: ') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{  __($tutor->address) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('State/Province') }}</label>
                        <div class="col-md-6 col-form-label">
                        {{  __($tutor->state()->first()['name']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Postal/Zip Code') }}</label>
                        <div class="col-md-6 col-form-label">
                        {{  __($tutor->pcode) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
                        <div class="col-md-6 col-form-label">
                        {{  __($tutor->country()->first()['name']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_name" class="col-md-4 col-form-label text-md-right">{{ __('Primary E-Mail:') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __($tutor->email) }}
                        </div>
                    </div>

                    <div class="form-group row">
                                By becoming a LearnOn! tutor I, <b> {{$tutor->fname . ' ' . $tutor->lname}} </b> (fill in first last name and have it be the exact same as you filled in the boxes of the first page) <b>agree to the following Terms & Conditions.</b>
                                <br>
                                <b>1. The terms and/or conditions in this agreement can not and will not be interpreted for any reason as the establishment of an employer/employee relationship. I understand that as an independent contractor, I will not be an employee of LearnOn! Tutoring and will not be entitled to participate in or to receive any benefits or rights from LearnOn! Tutoring’s employment benefits or welfare plans including but not limited to any pension plans, health plans, disability insurance, and workers compensation insurance. </b>
                                <br>
                                <b><span style="color: red">2. I must refuse direct payment by the student, their parents or guardians, LearnOn! will pay me for the tutoring services that I provide. </span></b>
                                <br>
                                <b>3. I am responsible for behaving in a professional manner at all times and will be held personally accountable for any inappropriate, illegal or questionable behavior. </b>
                                <br>
                                <b>4. LearnOn! is not liable for any damages, which occur to my person or property as a result of LearnOn! tutoring sessions, and I absolve LearnOn! of any liability by entering into this agreement.  </b>
                                <br>
                                <b>5. I understand that all company and client information is strictly confidential and distribution is strictly prohibited. </b>
                                <br>
                                <b>6. I understand that in order for parents and students to feel comfortable having me in their home I must follow a certain code of conduct. This includes being prepared, being on time, being polite and personable, and arriving properly dressed. </b>
                                <br>
                                <b>7. I am responsible for submitting my tutoring hours online accurately by the end of each calendar month using the LearnOn! online logging system, this is how I invoice LearnOn! for the services I have provided. I am also responsible for responding to all LearnOn! administration calls/emails pertaining to my students within 24 hours. </b>
                                <br>
                                <b>8. LearnOn! tutors are prohibited to make direct tutoring arrangements with LearnOn! clients while being under contract with LearnOn! and for a period of two (2) years after contract is terminated. </b>
                                <br>
                                <b>9. I agree that students, client, referrals and leads to prospective students belong to LearnOn! Tutoring. I agree that any breach of this provision may be considered theft of property and may result in legal action against me, and regardless of the outcome, I will reimburse LearnOn! Tutoring for all legal and administrative expenses incurred by LearnOn! Tutoring. </b>
                                <br>
                                <b>10. I may be presented at any time with a "mystery client" commissioned by LearnOn! to verify that I am complying with the Tutor Agreement. </b>
                                <br>
                                <b>11. I will be paid during the second half of the calendar month following the month in which I provided my service. My fee will be based on the tutor posting or the amount agreed upon with LearnOn! for that particular session.  </b>
                                <br>
                                <b>12. I understand that I will not be paid if I signed up for a session that I was not prepared for nor had sufficient knowledge to conduct and therefore was not done to the satisfaction of the student.  This does not mean, that if the student has bad grades after ongoing tutoring it is a reflection of my work.  It means that I will not sign up for a session, I know nothing about.  The students grades are not your responsibility and will not impact your pay after ongoing tutoring. </b>
                                <br>
                                <b>13. LearnOn! Tutoring shall not be liable for any expenses paid or incurred by myself unless otherwise agreed to ahead of time in writing. </b>
                                <br>
                                <b>14. I have no authority to enter into contracts or agreement on behalf of LearnOn! Tutoring. </b>
                                <br>
                                <b>15. I represent that I am in good mental and physical health and free from communicable diseases. If at any time, the state of my health may harm that of any LearnOn! Tutoring’s clients, I must report such change to LearnOn! Tutoring. </b>
                                <br>
                                <b>16. I certify that I do not have a criminal record and I have never been convicted of any crime.  </b>
                                <br>
                                <b>17. I certify that I have NEVER been charged with any sex-related or child abuse related offences and herby authorize LearnOn! Tutoring to run a background check on me with whatever authorities Learn On! Tutoring deems convenient, including but not limited to criminal records. </b>
                                <br>
                                <b>18. I absolve LearnOn! Tutoring for liability, actions or claims for any damages, in all areas of law, including but not limited to criminal, tort, contract, property and others. </b>
                                <br>
                                <b>19. I will refuse to be left unaccompanied with any student under the age of 16. I agree to indemnify and hold LearnOn! Tutoring harmless from any losses, liabilities damages, expenses, claims, and/or from failure to abide by any Federal, State/Provincial or Local law relating to my services.  </b>
                                <br>
                                <b>20. I understand that as an independent contractor no income tax, payroll tax or any form of government payments will be withheld or paid by LearnOn! Tutoring on behalf of me and therefore I am responsible for reporting my earnings and I am responsible for any income tax that must be paid.  </b>
                                <br>
                                <b>21. I am liable for all costs, expenses and expenditures including, and without limitation, the complete legal costs incurred by LearnOn! in enforcing this agreement as a result of any default of this Agreement by the tutor.  </b>
                                <br>
                                <b> {{$tutor->fname . ' ' . $tutor->lname}} </b> (fill in first last name and have it be the exact same as you filled in the boxes of the first page)<b>understand that stealing student or clients, tutoring and not reporting hours, or receiving payment directly from students/parents is strictly prohibited and will result in legal action being taken against me. I also agree that if legal action is taken due to this breach in policy that I will be responsible for reimbursement of legal charges, incurred by LearnOn! Tutoring. This includes all expenses for all legal proceedings related to the charges and any and all attempts to collect a debt.</b>
                                <br>
                                <b> {{$tutor->fname . ' ' . $tutor->lname}} </b>(fill in first last name and have it be the exact same as you filled in the boxes of the first page)<b>have carefully read, and fully understand all of the above Terms and Conditions.</b>
                            </div>  
                        </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
