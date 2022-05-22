<form method="post" id="sortForm" action="/sort">
    @csrf
    <div class="d-flex flex-sm-nowrap align-items-center">
        <span class="d-block " style="margin-right: 5px;">Сортування:</span>
        <select name="sort" id="sortSelect" class="form-control">
            <option @if($sort=='rating') selected @endif value="rating">рейтингу</option>
            <option @if($sort=='new_end') selected @endif value="new_end">від раніших</option>
            <option @if($sort=='end_new') selected @endif value="end_new">від пізніших</option>

        </select>
    </div>

</form>

