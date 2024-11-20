@if($categories ->count() > 0)
    <select class="form-control select2" name="category_id" id="sub-category" required>
        <option></option>
        @foreach($categories as $category)
            <option value="{{$category->id}}">{{(app()->getLocale()=='en')? $category->name_en:$category->name_ar}}</option>
        @endforeach 
    </select>
@endif