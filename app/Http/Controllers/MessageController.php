<?php

namespace App\Http\Controllers;

use App\Events\GotMessage;
use App\Events\TestEvent;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function messages()
    {
        $messages = Message::all();
        return response()->json($messages);

        // return 'hllow';

    }

    public function createMessage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'text' => 'required|string',

        ]);

        if ($validator->fails()) {

            return $validator->errors();
        } else {

            $message = new Message();
            $message->text = $request->get('text');
            $result = $message->save();
            if ($result) {
                      event(new \App\Events\GotMessage($message));
                return ['success' => "message successfully saved"];
          
            } else {

                return ['error' => "not saved to the db"];
            }
        }
    }
}
