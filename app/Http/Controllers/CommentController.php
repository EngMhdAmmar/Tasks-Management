<?php

namespace App\Http\Controllers;

use App\Http\Requests\comment\StoreRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(StoreRequest $request, String $task_id) {
        $user = auth()->user();
        $data = $request->validated();
        if($request->has('file')) {
            $data['attachment'] =  $request->file('file')->store('comments/' . $task_id, 'public');
        }
        $data['user_id'] = $user->id;
        $data['task_id'] = $task_id;
        Comment::create($data);
        return back();
    }

    public function download(String $id) {
        $comment = Comment::find($id);
        $filePath = 'public/' . $comment->attachment;
        if (!Storage::exists($filePath)) {
            abort(404);
        }
        return response()->download(storage_path('app/' . $filePath));
    }
}
