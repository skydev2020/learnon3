<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Paycheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class PaychequesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            't_name'            => 'nullable|string',
            'num_of_sessions'   => 'nullable|integer',
            'date_added'        => 'nullable|date',
            'status'            => 'nullable|string'
        ]);

        $q = "1=1 ";
        if (isset($request_data['num_of_sessions'])) {
            $q .= " and num like '%" . $request_data['num_of_sessions'] . "%'";
        } else $request_data['num_of_sessions'] = "";

        if (isset($request_data['date_added'])) {
            $q.= " and date_added like '%".$request_data['date_added']."%'";
        } else $request_data['date_added'] = "";

        if (isset($request_data['status'])) {
            $q.= " and status like '%".$request_data['status']."%'";
        } else $request_data['status'] = "";

        $paycheques = Paycheque::whereRaw($q);
        
        if (isset($request_data['t_name'])) {
            $paycheques = $paycheques->whereHas('users', function($user) use ($request_data) {
            return $user->where('fname', 'like', "%" . $request_data['t_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['t_name'] . "%");
            });
        } else $request_data['t_name'] = "";
        $paycheques = $paycheques->get();

        $data = [
            'paycheques'   => $paycheques,
            'old'        => $request_data,
        ];

       if( count($paycheques) == 0 ) $request->session()->flash('error', "No search results!");
        
        return view('admin.paycheques.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function show(Paycheque $paycheque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function edit(Paycheque $paycheque)
    {
        return view('admin.paycheques.edit')->with('paycheque', $paycheque);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paycheque $paycheque)
    {
        $validator = Validator::make($request->all(), [
            'paycheque_num'     => ['required', 'string'],
            'num_of_sessions'   => ['required', 'integer'],
            'total_hours'       => ['required', 'string'],
            'num_of_essays'     => ['required', 'integer'],
            'essay_amount'      => ['required', 'string'],
            'raise_amount'      => ['required', 'string'],
            'total_amount'      => ['required', 'string'],
            'paid_amount'       => ['required', 'string'],
            'paycheque_notes'   => ['required', 'string'],
            'status'            => ['required', 'string']
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->message()->first());
            return redirect()->route('admin.paycheques.edit');
        }

        $data = $request->all();
        $paycheque->paycheque_num = $data['paycheque_num'];
        $paycheque->num_of_sessions = $data['num_of_sessions'];
        $paycheque->total_hours = $data['total_hours'];
        $paycheque->num_of_essays = $data['num_of_essays'];
        $paycheque->essay_amount = $data['essay_amount'];
        $paycheque->raise_amount = $data['raise_amount'];
        $paycheque->total_amount = $data['total_amount'];
        $paycheque->paid_amount = $data['paid_amount'];
        $paycheque->paycheque_notes = $data['paycheque_notes'];
        $paycheque->status = $data['status'];

        if (!$paycheque->save())
        {
            $request->session()->flash('error', 'There is an error modifying paycheque!');
            return redirect()->route('admin.paycheques.edit');
        }

        $request->session()->flash('success', 'You have modified paycheque details!');
        return redirect()->route('admin.paycheques.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paycheque $paycheque)
    {
        if (Gate::denies('manage-payments'))
        {
            return redirect()->route('admin.paycheques.index');
        }

        $paycheque->delete();
        return redirect()->route('admin.paycheques.index');
    }

    public function markaspaid(Request $request, Paycheque $paycheque)
    {
        if (Gate::denies('manage-payments'))
        {
            return redirect()->route('admin.paycheques.index');
        }

        $paycheque->status = "Paid";
        if (!$paycheque->save())
        {
            $request->session()->flash('error', 'There is an error marking the Paycheques as Paid');
            return redirect()->route('admin.paycheques.index');
        }
        session()->flash('success', 'You have Marked the Paycheques as Paid');
        return redirect()->route('admin.paycheques.index');
    }

    public function lock(Request $request, Paycheque $paycheque)
    {
        if (Gate::denies('manage-payments'))
        {
            return redirect()->route('admin.paycheques.index');
        }

        $paycheque->is_locked = 1;
        if (!$paycheque->save())
        {
            $request->session()->flash('error', 'There is an error locking the Paycheque!');
            return redirect()->route('admin.paycheques.index');
        }
        session()->flash('success', 'You have Locked the Paycheque!');
        return redirect()->route('admin.paycheques.index');
    }

    public function unlock(Request $request, Paycheque $paycheque)
    {
        if (Gate::denies('manage-payments'))
        {
            return redirect()->route('admin.paycheques.index');
        }

        $paycheque->is_locked = 0;
        if (!$paycheque->save())
        {
            $request->session()->flash('error', 'There is an error Unlocking the Paycheque!');
            return redirect()->route('admin.paycheques.index');
        }
        session()->flash('success', 'You have Unlocked the Paycheque!');
        return redirect()->route('admin.paycheques.index');
    }
}
