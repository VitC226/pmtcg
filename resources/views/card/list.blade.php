@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($list as $item)
            <div class="col-xs-6">
                <a href="card/{{ $item->cardId }}" class="thumbnail">
                    <div class="caption">
                        <div class="text-warning">{{ $item->img }}</div>
                    </div>
                </a>
            </div>
        @endforeach
        <table class="table table-bordered table-hover">
            <tr><th>编号</th><th>卡片名</th><th>卡包</th><th>类型</th><th>属性</th><th>HP</th></tr>
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
            </tr>
        @endforeach
        </table>
        
    </div>
    {{ $list->links() }}
</div>
@endsection
