<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
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
                        <a class="btn btn-link" href="/admin/sys/card/{{ $sy->symbol }}" role="button">{{$sy->name}}</a>
                        @endif
                    @endforeach
                </div>
                @endforeach
              </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
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
                            <a target="_blank" href="/admin/sys/card/{{ $item->cardId }}/edit">编辑</a>
                        </td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
        {{ $list->links() }}
    </div>
</div>



