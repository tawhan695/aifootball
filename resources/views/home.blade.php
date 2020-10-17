@extends('layouts.app')

@section('content')

<style>
    .f-100{
        font-size: 5px;
    }
    #f-100{
        font-size: 5px;
    }

</style>
<script>
    $('#myTable').DataTable( {
    responsive: true
} );
</script>
{{-- Modal --}}
 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-danger">20 ล่าสุด</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            @foreach ($history as $item)
                <div class="p-1 m-1 text-center btn-warning">datetime :{{$item->date}} Accuracy: {{$item->Accuracy}}%</div>
            @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>
{{-- Modal --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 p-1">
            <div class="card-header bg-danger text-white">        
            </div>
            <div class="card ">
                <div class="card-body f-100 ">
                    <div class="alert alert-success">
                        <strong>update model !</strong> date @foreach ( $accuracy as $item)
                        {{$item ->date}} accuracy {{$item->Accuracy}}% <br>
                        ระบบจะสร้างโมเดลใหม่ 1 ครั้งต่อสัปดาห์ <a class=" text-info " data-toggle="modal" data-target="#myModal" >ดูเพิ่มเติม ประวัติความแม่นยำ</a>
                        @endforeach
                    </div>
                    <div class="alert alert-success">
                        <strong>Accuracy in predict  </strong>  @foreach ( $accuracy as $item)
                         accuracy {{$percent}}%
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 p-1 m-1">
            {{-- <div class="card-header"> --}}
                <div class="row">

                    @foreach ($datelist as $item)
                        <div class="col-4 col-md-4 col-lg-2">
                            @if (session('active')[0] == $item)
                                
                                <a class="btn btn-success " href="{{route('date',['date'=>$item])}}">{{$item}}</a>
                                @else
                                
                                <a class="btn btn-info " href="{{route('date',['date'=>$item])}}">{{$item}}</a>
                                {{-- <a class="btn btn-info " href="date/?date={{$item}}">{{$item}}</a> --}}
                            @endif
                        </div>
                    @endforeach
                   
                  
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>

@foreach ($Tablepredict as $item)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 p-1">
                <div class="card ">
                   
                    <div class="card-header bg-danger text-white"> @php
                        foreach ($item as $key => $value) {
                            echo $value->league;
                            break;
                        }
                    @endphp
                    </div>

                    <div class="card-body f-100 ">
                        <table class="table table-borderless" id="myTable">
                            <thead>
                                <tr>
                                    <th class="f-100 text-info" scope="col">Time</th>
                                    <th class="f-100 text-info" scope="col">Home</th>
                                    <th class="f-100 text-info" scope="col">FTR</th>
                                    <th class="f-100 text-info" scope="col">Away</th>
                                    <th class="f-100 text-info" scope="col">Predict</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ()
                                    
                                @elseif()
                                    
                                @endif
                                @foreach ($item as  $value)
                                    <tr class="@if ($value->FTR  == $value->predict) bg-success @elseif($value->FTR  != $value->predict) @if ($value->FTR !='') bg-warning @endif @endif">
                                        <th class="f-100"><p>{{Str::beforeLast($value->time, 'T')}} <br> {{Str::of($value->time)->after('T')}}</p></th>
                                        {{-- <th class="f-100">{{Str::beforeLast($value->time, 'T')}}</th> --}}
                                        <th class="f-100 overflow-auto" data-toggle="tooltip" title="{{$value->home}}" ><a href="">{{Str::limit($value->home, 12, ' ...')}}</a></th>
                                        <script>
                                            $(document).ready(function(){
                                              $('[data-toggle="tooltip"]').tooltip();   
                                            });
                                            </script>
                                        <th class="f-100">
                                            @if (!$value->FTR)
                                                --
                                            @else
                                                {{$value->FTR}}
                                                
                                            @endif
                                        </th>
                                        {{-- <th class="f-100 overflow-auto">{{Str::limit($value->away, 18, ' ...')}}</th> --}}
                                        <th class="f-100 overflow-auto" data-toggle="tooltip" title="{{$value->away}}" ><a href="">{{Str::limit($value->away, 12, ' ...')}}</a></th>
                                        <th class="f-100">{{$value->predict}} <br> Win rate 
                                            <br> H:{{$value->H}}%
                                            <br> D:{{$value->D}}%
                                            <br> A:{{$value->A}}%
                                        </th>
        
                                    </tr>
                                @endforeach
                               

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
