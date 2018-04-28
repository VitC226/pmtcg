@extends('layouts.admin')

@section('script')
<script>
  $(function(){
    $("#collect1").on('click',function(){
        if(!$("#input1").val()) return;
        $.post('collectIndex',{
            url:$("#input1").val()
        }, function(data){
            console.log(data);
            if(data.address && data.address.length > 0){
                var html = "";
                for(var item of data.address){
                    html+=item+"\n";
                }
                $("#input2").val(html);
            }
        });
    });
    $("#collect2").on('click',function(){
        var arr = $("#input2").val().split('\n');
        colectCard(arr[0]);
        /*for(var i of arr){
            colectCard(i);
        } */     
    });

    function colectCard(url){
        console.log(url);
        $.post('collectCard',{
            url:url
        }, function(data){
            console.log(data);
            /*if(data.address && data.address.length > 0){
                var html = "";
                for(var item of address){
                    html+=item+"<br>";
                }
                $("#input2").val(html);
            }*/
        });
    }
  });
</script>
@endsection

@section('content')
<h2 class="page-header">采集</h2>
<div class="row">
  <div class="col-lg-6">
    <div class="input-group">
      <input id="input1" type="text" class="form-control" placeholder="输入目录页">
      <span class="input-group-btn">
        <button id="collect1" class="btn btn-default" type="button">采集</button>
      </span>
    </div>
  </div>
  <div class="col-lg-6">
    <textarea id="input2" class="form-control" rows="4"></textarea>
    <button id="collect2" class="btn btn-default" type="button">采集以上地址</button>
  </div>
  <div class="col-lg-12" style="margin-top:20px">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Table heading</th>
            <th>Table heading</th>
            <th>Table heading</th>
            <th>Table heading</th>
            <th>Table heading</th>
            <th>Table heading</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
            <td>Table cell</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
    
</script>
@endsection
