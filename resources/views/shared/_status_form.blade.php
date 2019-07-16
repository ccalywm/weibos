<form action="{{ route('statuses.store') }}" method="POST">
    @include('shared._errors')
    {{ csrf_field() }}
    <label>类型：</label>
    <label class="form-check-label"> 支出<input type="radio" name="title" value="支出"></label>
    <label class="form-check-label"> 收入<input  type="radio" name="title" value="收入"></label>
{{--    <textarea class="form-control" rows="1" placeholder="类型..." name="title">{{ old('content') }}</textarea>--}}
    <textarea class="form-control" rows="2" placeholder="金额..." name="jine">{{ old('content') }}</textarea>
    <textarea class="form-control" rows="2" placeholder="备注..." name="content">{{ old('content') }}</textarea>
{{--    <textarea class="form-control" rows="2" placeholder="日期..." name="time" type="date">{{ old('content') }}</textarea>--}}
    <label> <input class="form-control" placeholder="日期..." name="time" type="date"> {{ old('content') }}</label>


    <div class="text-right">
        <button type="submit" class="btn btn-primary mt-3">发布</button>
    </div>
</form>
