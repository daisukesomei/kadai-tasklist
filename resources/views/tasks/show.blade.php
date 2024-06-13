@extends('layout.app')

@section('content')

    <div class="prose ml-4">
        <h2 class="text-lg">id= {{ $task->id }} のタスク詳細ページ</h2>
    </div>
    
    <table class="table w-full my-4">
        <tr>
            <th>id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th>タスク</th>
            <td>{{ $task->content }}</td>
        </tr>
    </table>
    
    {{-- タスク更新ページのリンク --}}
    <a class="btn btn-primary" href="{{ route('tasks.edit', $task->id) }}">このタスクを編集</a>

    {{-- メッセージ削除フォーム --}}
    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="my-2">
        @csrf
        @method('DELETE')
    
        <button type="submit" class="btn btn-error btn-outline" 
            onclick="return confirm('id = {{ $task->id }} のメッセージを削除します。よろしいですか？')">削除</button>
        
    </form>
@endsection