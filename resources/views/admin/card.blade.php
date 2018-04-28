@extends('layouts.admin')

@section('content')
<h1 class="page-header">卡片
    <div class="btn-group pull-right" role="group" aria-label="...">
      <a class="btn btn-default" href="collect">采集</a>
      <button type="button" class="btn btn-default">Middle</button>
      <button type="button" class="btn btn-default">Right</button>
    </div>
</h1>
<table class="table table-bordered table-hover">
            <tr><th>编号</th><th>卡片名</th><th>卡包</th><th>类型</th><th>属性</th><th>HP</th><th>操作</th></tr>
        @foreach ($list as $item)
            <tr>
                <td>
                    {{ $item->pkmId }}
                </td>
                <td>
                    <a href="card/{{ $item->cardId }}">{{ $item->title }}</a>
                </td>
                <td>
                    {{ $item->cate }}
                </td>
                <td>
                    {{ $item->tc }}
                </td>
                <td>
                    {{ $item->energyName }}
                </td>
                <td>
                    {{ $item->hp }}
                </td>
                <td>
                    <a href="cardEdit/{{ $item->cardId }}">编辑</a>
                </td>
            </tr>
        @endforeach
        </table>
        {{ $list->links() }}
@endsection
