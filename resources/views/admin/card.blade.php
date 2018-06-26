@extends('layouts.admin')

@section('content')
<h1 class="page-header">卡片
    <div class="btn-group pull-right" role="group" aria-label="...">
      <a class="btn btn-default" href="collect">采集</a>
      <button type="button" class="btn btn-default">Middle</button>
      <button type="button" class="btn btn-default">Right</button>
    </div>
</h1>
<!-- Nav tabs -->
<div>
  <ul class="nav nav-tabs" role="tablist">
    @foreach ($series as $item)
    <li role="presentation"><a href="#{{$item->series}}" aria-controls="{{$item->series}}" role="tab" data-toggle="tab">{{$item->series}}</a></li>
    @endforeach
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    @foreach ($series as $item)
    <div role="tabpanel" class="tab-pane" id="{{$item->series}}">
        @foreach ($symbol as $sy)
            @if($sy->series == $item->series)
            <a class="btn btn-link" href="/admin/card/{{ $sy->symbol }}" role="button">{{$sy->name}}</a>
            @endif
        @endforeach
    </div>
    @endforeach
  </div>
</div>
<table class="table table-bordered table-hover">
            <tr><th>编号</th><th>卡片名</th><th>卡包</th><th>操作</th></tr>
        @foreach ($list as $item)
            <tr>
                <td>
                    {{ $item->pkmId }}
                </td>
                <td>
                <a href="/admin/card/{{ $item->cardId }}">{{ $item->title }}</a>
                </td>
                <td>
                    {{ $item->cate }}
                </td>
                <td>
                    <a href="/admin/cardEdit/{{ $item->cardId }}">编辑</a>
                </td>
            </tr>
        @endforeach
        </table>
        {{ $list->links() }}
@endsection
