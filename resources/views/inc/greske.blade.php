@if($errors->any())
    <div class="greske">
        <ul>
            @foreach($errors->all() as $error)
                <li><h5>{{$error}}</h5></li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('uspesnaPoruka'))
    <div class="ispis_uspesno">
        <h4>{{session('uspesnaPoruka')}}</h4>
    </div>
@endif

@if(session('neuspesnaPoruka'))
    <div class="greske">
        <h4>{{session('neuspesnaPoruka')}}</h4>
    </div>
@endif