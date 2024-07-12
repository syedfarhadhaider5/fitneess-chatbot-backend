<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use OpenAI;
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
            'time' => 'required|date_format:H:i:s',
            'date' => 'required|date',
            'flag' => 'required|in:seen,unseen'
        ]);
        $apiKey = env('OPEN_API_KEY');

        // Prompt provided by the user

        $prompt = 'Behave like a professional fitness trainer, I want to save the response in div, li, h3 and h3 color #f9c604.';
        $question = $request->question;
        // Make API call to OpenAI
        $client = OpenAI::client($apiKey);
        $result = $client->chat()->create([
            'model' => 'gpt-4', // Use GPT-4 model
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $question],
            ],
        ]);
        // Extract the response
        $answer = $result->choices[0]->message->content;
        $message = new Message();
        $message->question = $request->question;
        $message->answer  = $answer ;
        $message->time = $request->time;
        $message->date = $request->date;
        $message->flag = $request->flag;
        $message->save();
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
