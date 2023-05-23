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
    public function index()
    {
        $messages =  Message::wher('is_feedback', false)->get();
        return FeedbackResource::collection($messages);
    }
    public function store(FeedbackRequest $request)
    {
        $data = $request->validated();
        $data['user_is'] = auth()->user()->id;
        $feedback = Message::create([
            'message'      => $data->message,
            'is_feedback'   => $data->is_feedback,
        ]);
        return response()->json([
            'message' => 'Message stored successfully.',
            'data' => $feedback,
        ]);
    }
    public function show(Message $message)
    {
        $feedback = Message::findOrFail($message);
        return response()->json([
            'data' => new FeedbackResource($feedback)
        ]);
    }
    public function destroy(Message $message)
    {
        $feedback = Message::findOrFail($message);
        $feedback->delete();
        return response()->json([
            'message' => 'Message deleted successfully.',
        ]);
    }
}
