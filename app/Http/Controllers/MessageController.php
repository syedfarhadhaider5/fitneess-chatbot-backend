<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Retrieve all messages
    public function index()
    {
        return response()->json(Message::all());
    }

    // Create a new message
    public function store(Request $request)
    {
        $this->validate($request, [
            'question' => 'required|string',
            'answer' => 'required|string',
            'time' => 'required|date_format:H:i:s',
            'date' => 'required|date',
            'flag' => 'required|in:seen,unseen'
        ]);

        $message = Message::create($request->all());

        return response()->json($message, 201);
    }

    // Show a specific message
    public function show($id)
    {
        return response()->json(Message::find($id));
    }

    // Update a message
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'question' => 'sometimes|required|string',
            'answer' => 'sometimes|required|string',
            'time' => 'sometimes|required|date_format:H:i:s',
            'date' => 'sometimes|required|date',
            'flag' => 'sometimes|required|in:seen,unseen'
        ]);

        $message = Message::findOrFail($id);
        $message->update($request->all());

        return response()->json($message, 200);
    }

    // Delete a message
    public function destroy($id)
    {
        Message::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
