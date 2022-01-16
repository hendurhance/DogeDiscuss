<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'read' => auth()->user()->readNotifications,
            'unread' => auth()->user()->unreadNotifications
        ];
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
     * Mark the given notification as read.
     * Only the user that owns the notification can mark it as read.
     * 
     */
    public function markAsRead($id)
    {
        auth()->user()->notifications->find($id)->markAsRead();
        return response([
                'message' => 'Notification marked as read.'
            ], Response::HTTP_OK
        );
    }
}
