@extends('layouts.layout')

@section('title')
    Admin - Sve aktivnosti
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Sve Aktivnosti</p>
    </div>

    @if(count($aktivnosti))

        <div id="aktivnost_sortDiv">
            <form method="GET" action="{{route('aktivnost.index')}}">
                <select name="aktivnost_sort" id="aktivnost_sort">
                    <option value="desc" @if($sort == 'desc') selected @endif>Najnovije</option>
                    <option value="asc" @if($sort == 'asc') selected @endif>Najstarije</option>
                </select>
                <input type="submit" value="SORTIRAJ" id="aktivnost_sortDugme"/>
            </form>
        </div>


        <div class="stranice">
            {{$aktivnosti->appends(['aktivnost_sort' => $sort])->links()}}
        </div>

        <div id="allusers_sadrzaj">
            <table class="tabela">
                <tr>
                    <th>RB</th>
                    <th>ID</th>
                    <th>AKTIVNOST</th>
                    <th>DATUM I VREME DOGAĐANJA</th>
                </tr>
                @foreach($aktivnosti as $a)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$a->aktivnostID}}</td>
                        <td>{{$a->aktivnost}}</td>
                        <td>
                            @if($a->aktivnost_created_at != "")
                                {{date("d.m.Y H:i:s", $a->aktivnost_created_at)}}h
                            @else
                                Nema podatka
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="stranice">
            {{$aktivnosti->appends(['aktivnost_sort' => $sort])->links()}}
        </div>
    @else
        <div class="trenutno_nema">
            <p>Trenutno nema aktivnosti</p>
        </div>
    @endif
@endsection