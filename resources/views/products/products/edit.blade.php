@extends('layouts.app')

@section('title','Editar product')

@section('content')

<div class="content-wrapper" style="background-color: #427D9D">
    <section class="content-header">
		<div class="container-fluid">
		</div>
    </section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header" style="background-color: #427D9D">
							<h3>Edit Product</h3>
						</div>
						<form method="POST" action="{{ route('products.update',$product) }}" enctype="multipart/form-data">
                            @csrf
							@method('PUT')
							<div class="card-body" style="background-color: #FBF9F1;">
								<div class="row">
									<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
										<div class="form-group label-floating">
											<label class="control-label">Nombre<strong style="color:red;">(*)</strong></label>
											<input type="text" class="form-control" name="name" placeholder="Ejemplo, nombre" autocomplete="off" value="{{ $product->name }}">
										</div>
                                        <div class="form-group label-floating">
											<label class="control-label">Precio<strong style="color:red;">(*)</strong></label>
											<input type="text" class="form-control" name="purchase_price" placeholder="$000" autocomplete="off" value="{{ $product->purchase_price }}">
										</div>
                                        <div class="form-group label-floating">
											<label class="control-label">Cantidad<strong style="color:red;">(*)</strong></label>
											<input type="text" class="form-control" name="stock_quantity" placeholder="0" autocomplete="off" value="{{ $product->stock_quantity }}">
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Descripción<strong style="color:red;">(*)</strong></label>
                                        	<div class="form-group label-floating">
                                        	    <div style="display:flex;">
											        <textarea class="form-control" name="description" rows="3" placeholder="Descripción" >{{ $product->description }}</textarea>
                                        	    </div>
											</div>
										</div>
                                        <div class="row">
                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Imagen</label>
                                                <input type="file" class="form-control-file" name="image" id="image">
												@if($product->image)
            										<img src="{{ asset('uploads/products/'.$product->image) }}" alt="Product Image" style="height: 70px; width: 70px">
        										@endif
                                            </div>
                                        </div>
									</div>
								</div>
								<input type="hidden" class="form-control" name="registered_by" value="{{ Auth::user()->id }}">
							</div>
							<div class="card-footer">
								<div class="row">
									<div class="col-lg-2 col-xs-4">
										<button type="submit" class="btn btn-block" style="background-color: #40A578;">Editar</button>
									</div>
									<div class="col-lg-2 col-xs-4">
										<a href="{{ route('products.index') }}" class="btn btn-danger btn-block btn-flat">Atras</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection