<div class="naslov_svaki_boja">
    <p>Najpopularnije objave</p>
</div>

@if(count($najpopularnijeObjave))
    @foreach($najpopularnijeObjave as $objava)
        @component('components.jednaobjava', ["objava" => $objava])
        @endcomponent
        <br/><br/>
        @if(!$loop->last)
            <div class="razvdavanje_objava"></div>
        @endif
        <br/><br/>
    @endforeach
@else
    <div class="naslov_svaki">
        <p>Nema objava</p>
    </div>
@endif