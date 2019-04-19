<div class="form-group">
    <strong> Navn: </strong>
    <input type="text" name="name" value="{{old('name', (isset($link->name)? $link->name : null))}}" required class="form-control" placeholder="Navn">
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong> Verdi: </strong>
    <input type="text" name="value" value="{{old('value', (isset($link->value)? $link->value : null))}}" required class="form-control" placeholder="Verdi">
</div>
<div class="form-group">
    <strong> Velg page:</strong>
    <select name="page_id"  class="form-control" >
        <option></option>
        @foreach($pages as $page)
            <option value="{{$page->id}}" {{('page_id' == $page->id)? 'selected' :'' }}> {{$page->title}} </option>
        @endforeach
    </select>
</div>
