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
        
        $data = [];
        if(\Auth::check()) {
            //認証済みユーザーを取得
            $user = \Auth::user();
            //ユーザーのタスク一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [ 'user' => $user , 'tasks' => $tasks];
        }

        //タスク一覧ビューでそれを表示
        return view('dashboard', $data);
        
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
        
        //認証済みユーザー（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create(['content' => $request->content, 'status' => $request->status]);
        
        // $task = new Task;   //新規登録の為、インスタンスを作成
        // $task->status = $request->status;
        // $task->content = $request->content; //フォームで送られてきたcontentを代入
        // $task->save();  //DBに保存
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
        
        //ログインidとuser_idが一致していたら詳細を表示。一致しない場合トップページへリダイレクト
        if(\Auth::id() === $task->user_id){
        //タスク詳細ビューで表示
        return view('tasks.show', [ 'task' => $task]);
        }else{
        //トップページへリダイレクト
        return redirect('/');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
     //getでtasks/(任意のid)にアクセスされた場合の「更新画面表示処理」
    public function edit(string $id)
    {
        $task = Task::findOrFail($id); //idの該当タスクを取得し代入
        
        //ログインidとuser_idが一致していたら更新画面を表示。一致しない場合トップページへリダイレクト
        if(\Auth::id() === $task->user_id){
        //タスク更新をビューで表示
        return view('tasks.edit', [ 'task' => $task]);
        }else{
        //トップページへリダイレクト
        return redirect('/');
        }
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
            
        //認証済みユーザー（閲覧者）としてタスクをアップデート

        $task = Task::findOrFail($id);
        
        //ログインidとuser_idが一致していたらupdateを実施。
        if(\Auth::id() === $task->user_id) {
            $task->update(['content' => $request->content, 'status' => $request->status]);
        }
        // $task->status = $request->status;
        // $task->content = $request->content;
        // $task->save();
        
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
        
        //認証済みユーザー（閲覧者）がその投稿の所有者である場合は投稿を削除
        if(\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        //トップページへリダイレクト
        return redirect('/');
    }
}
