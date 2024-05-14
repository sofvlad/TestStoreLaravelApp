<form id="product-filters" class="row g-3">
    <div class="mb-3 mt-2 ml-3">
        <label class="form-label fs-5" for="price">Поиск</label>
        <input type="text" class="form-control" name="filters[search]">
    </div>
    <hr/>
    <div class="mb-3 mt-2 ml-3">
        <label class="form-label fs-5" for="price">Цена</label>
        <div class="input-group">
            <input type="number" placeholder="От" class="form-control" name="filters[price][from]">
            <input type="number" placeholder="До" class="form-control" name="filters[price][to]">
        </div>
    </div>
    <hr/>
    @foreach ($attributes as $attribute)
    <div class="mb-3 mt-2 ml-3">
        @if ($attribute->type == 'bool')
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="filters[{{ $attribute->code }}]" value="1" @if($attribute->getOriginal('value')) checked @endif>
            <label class="form-check-label">{{ $attribute->name }}</label>
        </div>
        @elseif (!empty($attribute->option))
        <label class="form-label fs-5" for="{{ $attribute->code }}">{{ $attribute->name }}</label>
        <div>
        <select class="form-select" name="filters[{{ $attribute->code }}][]" size="@php count($attribute->getOptionValues()) >= 10 ? 10: 5 @endphp" multiple>
        @foreach ($attribute->getOptionValues() as $optionKey => $optionValue)
            <option value="{{ $optionKey }}">{{ $optionValue }}</option>
        @endforeach
        </select>
        </div>
        @endif
    </div>
    <hr/>
    @endforeach
    <div class="col-auto">
        <button id="product-filters-form-submit" type="submit" class="btn btn-primary mb-3">Применить</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $((decodeURI(window.location.search)).substr(1).split('&')).each(function() {
            var inputData = (this).split('=');
            inputData[0] = inputData[0].replace(/\[\d\]$/, '[]');
            var input = $('#product-filters').find('select[name="' + inputData[0] + '"],input[name="' + inputData[0] + '"]');
            if (input.length == 0) {
                return;
            }
            if (input.attr('type') == 'checkbox') {
                input.prop('checked', true);
            } else if (input.prop('tagName') == 'SELECT') {
                input.find('option[value="' + inputData[1] + '"]').prop('selected', true);
            } else {
                input.val(inputData[1]);
            }
        });
    });
</script>
