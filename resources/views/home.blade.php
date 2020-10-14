@extends('layouts.app')

@section('content')

<style>
    .f-100{
        font-size: 5px
    }

</style>
<script>
    $('#myTable').DataTable( {
    responsive: true
} );
</script>
@foreach ($Tablepredict as $item)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 p-1">
                <div class="card">
                   
                    <div class="card-header"> @php
                        foreach ($item as $key => $value) {
                            echo $value->league;
                            break;
                        }
                    @endphp
                    </div>

                    <div class="card-body ">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th class="f-100" scope="col">Time</th>
                                    <th class="f-100" scope="col">Home</th>
                                    <th class="f-100" scope="col">FTR</th>
                                    <th class="f-100" scope="col">Away</th>
                                    <th class="f-100" scope="col">Predict</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item as  $value)
                                    <tr>
                                        <th class="f-100">{{$value->time}}</th>
                                        <th class="f-100 overflow-auto">{{$value->home}}</th>
                                        <th class="f-100">
                                            @if (!$value->FTR)
                                                --
                                            @else
                                                {{$value->FTR}}
                                                
                                            @endif
                                        </th>
                                        <th class="f-100 overflow-auto">{{$value->away}}</th>
                                        <th class="f-100">{{$value->predict}}</th>
        
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
