<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MessageResource;
use App\Http\Requests\StoreMessageRequest;

class MessageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $messages = Message::orderByDesc('created_at')->paginate(6);
    // varDump($messages, 'messages');
    // varDump(MessageResource::collection($messages), 'coll');
    return MessageResource::collection($messages);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreMessageRequest $request)
  {
    varDump($request, 'request');
    $user = Auth::user();
    $message = new Message(['body' => $request->body]);
    $user->messages()->save($message);

    $messages = Message::orderByDesc('created_at')->paginate(6);
    return MessageResource::collection($messages);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Message $message)
  {
    // varDump($message, 'message');
      // $message = Message::find($id);
    return new MessageResource($message);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    logd("body=" . $request->body);
    // varDump($request, 'request');
    // varDump($request, 'request');
    return true;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }
}
