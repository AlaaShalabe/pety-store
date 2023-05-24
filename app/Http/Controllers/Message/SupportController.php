<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\SupportRequest;
use App\Http\Resources\Message\SupportResource;
use App\Models\Message;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $messages =  Message::where('is_feedback', '=', 0)->get();
        return SupportResource::collection($messages);
    }

    public function store(SupportRequest $request)
    {
        $data = $request->validated();
        $data['is_feedback'] = false;
        $feedback = Message::create($data);
        return response()->json([
            'message' => 'Message stored successfully.',
            'data' => new SupportResource($feedback),
        ]);
    }

    public function show(Message $message)
    {
        Message::find($message);
        return response()->json([
            'data' => new SupportResource($message)
        ]);
    }
    
    public function destroy(Message $message)
    {
        Message::find($message);
        $message->delete();
        return response()->json([
            'message' => 'Message deleted successfully.',
        ]);
    }
}
