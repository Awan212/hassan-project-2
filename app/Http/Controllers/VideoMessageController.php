<?php

namespace App\Http\Controllers;

use App\Models\VideoMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VideoMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.video-message.index');
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'video' => 'required'
        ]);
        if($validator->fails())
        {
            $data = [
                'response' => false,
                'message'  => $validator->errors()->all()
            ];
            return response()->json($data);
        }
        else
        {

            $file = $request->file('video');
            $file_new = time().$file->getClientOriginalName();
            $file->move('video/',$file_new);
            $data = new VideoMessage();
            $data->body = 'video/'.$file_new;
            $data->save();
            VideoMessage::where('id', '!=', $data->id)->update(['status'=> 0]);
            $data = [
                'response' => true,
                'message'  => ['video uploaded successfully'],
                'class'    => 'alert alert-success',
            ];
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoMessage  $videoMessage
     * @return \Illuminate\Http\Response
     */
    public function show(VideoMessage $videoMessage)
    {
        return response()->json(VideoMessage::orderBy('status', 'DESC')->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VideoMessage  $videoMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(VideoMessage $videoMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VideoMessage  $videoMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VideoMessage $videoMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VideoMessage  $videoMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = VideoMessage::find($id);
        $message->delete();
        if($message->status == 1)
        {
            try
            {
                $status = VideoMessage::latest()->first();
                $status->status = 1;
                $status->save();
                $data = [
                    'response' => true,
                    'message'  => ['video removed successfully'],
                    'class'    => 'alert alert-success',
                ];
                return response()->json($data);
            }
            catch(\Exception $ex)
            {
                $data = [
                    'response' => true,
                    'message'  => ['video removed successfully'],
                    'class'    => 'alert alert-success',
                ];
                return response()->json($data);
            }

        }
        else
        {
            $data = [
                'response' => true,
                'message'  => ['video removed successfully'],
                'class'    => 'alert alert-success',
            ];
            return response()->json($data);
        }

    }
}
