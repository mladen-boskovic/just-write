<div class="naslov_svaki_boja">
    <p>Zadnja objava</p>
</div>

@if($zadnjaObjava)
    @component('components.jednaobjava', ["objava" => $zadnjaObjava])
    @endcomponent
    <br/><br/><br/><br/>
@else
    <div class="naslov_svaki">
        <p>Nema objava</p>
    </div>
@endif