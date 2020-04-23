<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.notifications.index')->with('notifications', Notification::all());
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
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        return view('admin.notifications.show')->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }

    /**
     * Remove multiple notifications from database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request)
    {
        $data = $request->all();
		if (isset($data['sids']) && $this->validateMultiDelete()) {
            $sids = $data['sids'];
            $obj_ids = explode(",", $sids);

			foreach ($obj_ids as $id) {
                $obj = Notification::find($id);
                $obj->delete();				
			}
			            
            $request->session()->flash('success', 'You have modified information!');
			// $url = '';
			
			// if (isset($this->request->get['page'])) {
			// 	$url .= '&page=' . $this->request->get['page'];
			// }
			// if (isset($this->request->get['sort'])) {
			// 	$url .= '&sort=' . $this->request->get['sort'];
			// }
			// if (isset($this->request->get['order'])) {
			// 	$url .= '&order=' . $this->request->get['order'];
			// }
			
            // $this->redirect(HTTPS_SERVER . 'index.php?route=cms/notifications&token=' . $this->session->data['token'] . $url);
            return redirect()->route('admin.notifications.index');
		}
        $request->session()->flash('error', 'No id is selected!');
        return redirect()->route('admin.notifications.index');
    }

    /**
     * Check Multi Delete Permission, not implemented at the moment
     */
    public function validateMultiDelete()
    {
        return true;
    }
}
