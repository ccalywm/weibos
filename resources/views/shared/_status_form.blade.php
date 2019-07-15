<form action="{{ route('statuses.store') }}" method="POST">
    @include('shared._errors')
    {{ csrf_field() }}
    <textarea class="form-control" rows="1" placeholder="标题..." name="title">{{ old('content') }}</textarea>
    <textarea class="form-control" rows="2" placeholder="备注..." name="content">{{ old('content') }}</textarea>
    <textarea class="form-control" rows="2" placeholder="金额..." name="jine">{{ old('content') }}</textarea>
    <textarea class="form-control" rows="2" placeholder="日期..." name="time" type="data">{{ old('content') }}</textarea>


    <div class="text-right">
        <button type="submit" class="btn btn-primary mt-3">发布</button>
    </div>
</form>
