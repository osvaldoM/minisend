<?php

namespace App\Http\Controllers;

use App\Events\NewEmailPosted;
use App\Events\EmailResend;
use App\Http\Requests\StoreEmailRequest;
use App\Mail\UserMail;
use App\Models\Attachment;
use App\Models\Email;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $emails_query = Email::with(['message', 'message.attachments', 'statuses','current_status'])->orderBy('created_at', 'DESC');

        /*
         * I could have used fulltext search here, but I will not for the sake of simplicity, since laravel has no native support for fulltext search
         *  I would have to make assumptions on the db server being used(whether its mysql, pgsql, sqlite, etc)
         *
         */
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
    public function store(StoreEmailRequest $request)
    {
        $validated = $request->validated();

        $message = Message::make([
            'from' => $validated['from'],
            'to' => $validated['to'],
            'subject' => $validated['subject'],
            'text_content' => $validated['text_content'],
            'html_content' => $validated['html_content'],
        ]);

        $email = Email::create([
            'should_fail' => $validated['should_fail']
        ]);

        $email->message()->save($message);
        $attachments = [];

        if ($request->hasfile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $hashname = $file->hashName();
                Storage::putFileAs(config('uploads.attachments_folder_path'), $file, $hashname);

                $attachments[] = Attachment::make([
                   'filename' => $hashname,
                    'original_filename' => $file->getClientOriginalName()
                ]);
            }
        }

        $email->message->attachments()->saveMany($attachments);

        $email->setPosted();

        event(new NewEmailPosted($email));

        return response()->json($email, 201);
    }

    /**
     * @param Email $email
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Email $email)
    {
        $email->should_fail = false;
        $email->save();
        $email->setReposted();
        event(New EmailResend($email));
        return response()->json($email);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        $email->loadMissing(['message', 'message.attachments', 'statuses','current_status']);
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
        })->with(['message', 'message.attachments', 'statuses', 'current_status'])->get();

        return  response()->json($emails_to_recipient);
    }

    function open_in_browser (Email $email) {
        return new UserMail($email);
    }
}
