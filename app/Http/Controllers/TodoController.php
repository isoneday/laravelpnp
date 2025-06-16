<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255|min:1'
        ]);

        $todo = Todo::create([
            'title' => trim($request->title)
        ]);

        return response()->json([
            'success' => true,
            'todo' => $todo
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255|min:1'
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update([
            'title' => trim($request->title)
        ]);

        return response()->json([
            'success' => true,
            'todo' => $todo,
            'message' => 'Tugas berhasil diupdate'
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus'
        ]);
    }
}