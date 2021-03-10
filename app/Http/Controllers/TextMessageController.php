<?php

namespace App\Http\Controllers;

use App\Models\TextMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class TextMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.text-message.index', [
            'messages' => TextMessage::orderBY('status', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'body'  => 'required',
            ]);
            if($validator->fails())
            {
                return back()->withErrors($validator)->withInput();
            }
            else
            {

                $data = new TextMessage();
                $data->body = $request->body;
                $data->status = 1;
                $data->save();
                TextMessage::where('id', '!=', $data->id)->update(['status' => 0]);
                return back()->with('message', 'Your new text message save successfully.');
            }
        } catch (\Exception $ex) {
            //throw $th;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TextMessage  $textMessage
     * @return \Illuminate\Http\Response
     */
    public function show(TextMessage $textMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TextMessage  $textMessage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.text-message.edit', [
            'message' => TextMessage::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TextMessage  $textMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'body'  => 'required',
            ]);
            if($validator->fails())
            {
                return back()->withErrors($validator)->withInput();
            }
            else
            {

                TextMessage::where('id', $id)->update([
                    'body' => $request->body,
                    'status' => $request->status,
                ]);
                if($request->status = 1)
                {
                    TextMessage::where('id', '!=', $id)->update(['status' => 0]);
                }

                return back()->with('message', 'Your new text message updated successfully.');
            }
        } catch (\Exception $ex) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TextMessage  $textMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $textMessage = TextMessage::find($id);
        $textMessage->delete();
        return back()->with('message', 'Your text message removed successfully.');
    }
}
