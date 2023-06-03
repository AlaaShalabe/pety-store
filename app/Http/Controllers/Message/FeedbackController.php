<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\FeedbackRequest;
use App\Http\Resources\Message\FeedbackResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['except' => 'store']);
    }

    public function index()
    {
        $messages =  Message::where('is_feedback', '=', 1)->get();
        return FeedbackResource::collection($messages);
    }
    public function store(FeedbackRequest $request)
    {
        $data = $request->validated();
        $data['is_feedback'] = true;
        $feedback = Message::create($data);
        return response()->json([
            'message' => 'Message stored successfully.',
            'data' => new FeedbackResource($feedback),
        ]);
    }
    public function show(Message $message)
    {
        Message::find($message);
        return response()->json([
            'data' => new FeedbackResource($message)
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
