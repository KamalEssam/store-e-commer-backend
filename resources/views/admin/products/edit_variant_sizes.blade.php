{{ Html::style('assets/apps/css/chosen.min.css') }}

<div class="container">
    {{ Form::open(['route' => ['product.update-variant-sizes',$variant->id], 'id' => 'form-edit-variant-sizes', 'role' => 'Form' ]) }}
    <div>
        <h3 class="text-left" style="margin-left: 2%;">Variant Color : {{ $variant->color  ?? ''}}</h3>
    </div>
    <div class="form-group col-md-6">
        {{ Form::select('sizes[]', (new \App\Http\Repositories\SizeRepository())->getArrayOfSizes(), $sizes,[ 'class'=>'form-control select-sizes ' . ($errors->has('color') ? 'redborder' : '') ,'multiple', 'id'=>'color[]','required' => 'required']) }}
    </div>
    {{  Form::submit('save' , ['class' => 'btn-loon mt-2 btn btn-sm btn-primary btn-update-variant-sizes' ]) }}
    {{ Form::close()  }}
</div>

<br><br>
<br><br>
<br><br>
<br><br>

{{ Html::script('assets/apps/scripts/chosen.jquery.min.js') }}
<script>
    $('.select-sizes').chosen();
    $('#color___chosen').css({'width': '80%'})
</script>
