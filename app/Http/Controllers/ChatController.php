<?php

namespace App\Http\Controllers;

use App\Neuron\MyAgent;
use Illuminate\Http\Request;
use NeuronAI\Chat\Messages\UserMessage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController extends Controller
{
    /**
     * Show the chat interface with data reference sidebar
     */
    public function show(): \Illuminate\View\View
    {
        return view('chat');
    }

    /**
     * Stream chat responses via Server-Sent Events
     */
    public function stream(Request $request): StreamedResponse
    {
        $message = $request->input('message');
        $threadId = $request->input('thread_id', $request->session()->getId());

        return response()->stream(function () use ($message, $threadId) {
            // Set SSE headers
            header('Cache-Control: no-cache');
            header('Content-Type: text/event-stream');
            header('X-Accel-Buffering: no');

            try {
                // Initialize the agent with the thread ID for chat history
                $agent = new MyAgent($threadId);
                $response = $agent->chat(new UserMessage($message));
                $responseContent = $response->getContent();

                // Stream the response
                echo 'data: '.json_encode(['message' => $responseContent])."\n\n";
                flush();
            } catch (\Exception $e) {
                $errorMessage = "Error processing your query: {$e->getMessage()}";
                echo 'data: '.json_encode(['message' => $errorMessage])."\n\n";
                flush();
            }
        });
    }
}
