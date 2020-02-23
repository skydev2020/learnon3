@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Students</div>

                <div class="card-body">
                    
                    <div class="form-group row">
                        <label for="s_name" class="col-md-4 col-form-label text-md-right">{{ __('User Id:') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __($student->email) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Signup Date') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __(date("Y/m/d, $student->created_at")) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __($student->fname) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{ __($student->lname) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Telephone') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{  __($student->home_phone) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Cell/Work Phone') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{  __($student->cell_phone) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Home Address') }}</label>
                        <div class="col-md-6 col-form-label">
                            {{  __($student->address) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('State/Province') }}</label>
                        <div class="col-md-6 col-form-label">
                        {{  __($student->state()->first()['name']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Postal Code') }}</label>
                        <div class="col-md-6 col-form-label">
                        {{  __($student->pcode) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
                        <div class="col-md-6 col-form-label">
                        {{  __($student->country()->first()['name']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                            <textarea class="form-control inputstl"  name = "term_val" id="term_val" rows="10"  readonly="">

                    1. You certify that you are at least 18 years old and that you are the legal guardian of the
child/children being registered.
2. If you are not over 18, you MUST have parental permission to sign up for LearnOn! Tutoring.
3. Appointments cancelled with less than 24 hours notice will be billed a minimum of 1 hour/session.
4. Appointments changed to another day can however waive this minimum fee.
5. You are billed at the end of every month for all hours/sessions completed throughout the calendar
month. Payment is expected within 7 days. 
6. Invoices more than 1 month late will have a $20/month late fee applied for every month that it is
late.
7. Tutoring sessions are 60 minutes and you will be billed for a minimum 60 minutes, anything over
that is billed at a fraction of the rate.
8. We do NOT offer a money back, first class free, "demo" or "trial" session offer.
9. There are NO REFUNDS or partial refunds on pre-purchased packages. We will keep changing
tutors until you are happy with one.
10. Tutoring sessions are arranged directly with the LearnOn! office, tutors and clients are not to
have ANY contact with each other outside of the prearranged sessions, unless given permission by
the office.
11. If you arrange a tutoring session with LearnOn! and fail to appear or be available for the
scheduled appointment you will be liable for 1 session of payment.
12. We offer in-home tutoring, however should a tutor, for any reason feel uncomfortable or unsafe
at your home he/she can choose to stop going at his/her discretion.
13. Students under the age of 16 should not be left at home alone with the tutor, this is a
precautionary measure that should be taken to avoid any possible disputes.
14. Tutoring sessions are paid to LearnOn! and are not to be made to the tutors, we compensate the
tutors under already set agreements (please contact us for specific instructions).
15. WE ARE NOT LIABLE FOR ANY DAMAGE (real or imagined), WHICH OCCURS TO A
PERSON OR PROPERTY AS A RESULT OR AS A PERCEIVED RESULT OF TUTORING
SESSIONS PROVIDED BY LearnOn! By entering into a tutoring agreement with LearnOn! you
accept that LearnOn! is not responsible for any damage, loss, theft, or bodily harm that may arise
from tutoring sessions arranged with LearnOn! We provide tutors that are trustworthy and
responsible, we do checks on them, check with references and take all the precautionary means
that are available to us however any issue that arises with an individual tutor must be taken up
directly with the tutor and is separate in its entirety from LearnOn!
16. BY ENTERING INTO ANY FORM OF ARRANGEMENT OR AGREEMENT WITH LearnOn!,
YOU AGREE TO ABSOLVE LearnOn! FOR LIABILITY, ACTIONS OR CLAIMS FOR ANY
DAMAGES, IN ALL AREAS OF LAW, INCLUDING BUT NOT LIMITER TO CRIMINAL, TORT,
CONTRACT, PROPERTY AND OTHERS. 
17. LearnOn! strives to provide you with the best available tutors and the best academic help
possible. We want to help you understand the basics as well as prepare you for exams, however
LearnOn! nor any individual tutor will be held accountable or responsible for the academic success
or lack thereof demonstrated by the student/client, however we will do everything in our power to
help grades/skills improve.
18. YOU the client AGREE that you will NOT solicit any tutor who is assigned to you by LearnOn
tutoring for any direct private tutoring services.
19. YOU the client AGREE that you will NOT make direct payment to any tutor and "skip" over
LearnOn! Tutoring.
20. If you the client breaks the agreement and makes a direct deal with a tutor assigned to you by
LearnOn! Tutoring you are financially liable to LearnOn! Tutoring for all the sessions obtained
privately from the tutor. You the client are financially responsible for all legal, collection and court
costs that LearnOn! Tutoring incurs in order to enforce this agreement, that includes all lost
revenues from paying the tutor directly, soliciting the tutors services privately and skipping over
LearnOn! Tutoring.
 I, Kurazhrot Kurazhrot, have carefully read and agree to
the Terms & Conditions
                                </textarea>
                            </div>  
                        </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
