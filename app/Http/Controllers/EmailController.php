<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_query = $request->query('query');

        $recipient = $request->query('recipient');

        $emails_query = Email::with(['message', 'statuses']);

        if($search_query) {
            $emails_query = $emails_query->whereLike(['message.from', 'message.to', 'message.subject'], $search_query);
        }

        if($recipient) {
            $emails_query = $emails_query->whereHas('message', function ($query) use ($recipient) {
                return $query->where('to', '=', $recipient);
            });
        }

        return response()->json($emails_query->paginate()->withQueryString());

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
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        $email->loadMissing(['message', 'statuses']);
        return response()->json($email);
    }

    /**
     * Display emails from recipient
     *
     * @param String $recipient
     * @return \Illuminate\Http\Response
     */
    public function get_recipient_emails(String $recipient)
    {
        $emails_to_recipient =  Email::whereHas('message', function ($query) use ($recipient) {
           return $query->where('to', '=', $recipient);
        })->with(['message', 'statuses'])->get();

        return  response()->json($emails_to_recipient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        //
    }
}
