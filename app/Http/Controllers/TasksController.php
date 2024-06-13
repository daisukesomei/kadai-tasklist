<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//モデルのTaskを読み込み
use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     //getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        //タスク一覧を取得
        $tasks = Task::all();
        
        //タスク一覧ビューでそれを表示
        return view('tasks.index', ['tasks' => $tasks]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
     //getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;   //新規登録のためインスタンスを作成
        //メッセージ作成ビューを表示
        return view('tasks.create', [ 'task' => $task]);
    }

    /**
     * Store a newly created resource in storage.
     */
     //postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255'
            ]);
        
        $task = new Task;   //新規登録の為、インスタンスを作成
        $task->status = $request->status;
        $task->content = $request->content; //フォームで送られてきたcontentを代入
        $task->save();  //DBに保存
        //トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
     //getでtasks/(任意のid)にアクセスされた場合の「取得表示処理」
    public function show(string $id)
    {
        $task = Task::findOrFail($id);  //idの該当タスクを取得し代入
        //タスク詳細ビューで表示
        return view('tasks.show', [ 'task' => $task]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
     //getでtasks/(任意のid)にアクセスされた場合の「更新画面表示処理」
    public function edit(string $id)
    {
        $task = Task::findOrFail($id); //idの該当タスクを取得し代入
        //タスク更新をビューで表示
        return view('tasks.edit', [ 'task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
     //putまたはpatchでtasks/(任意のid)にアクセスされた場合の「更新処理」
    public function update(Request $request, string $id)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255'
            ]);


        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        //トップページへリダイレクト
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
     //deleteでtasks/(任意のid)にアクセスされた場合の「削除処理」
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        //トップページへリダイレクト
        return redirect('/');
    }
}
