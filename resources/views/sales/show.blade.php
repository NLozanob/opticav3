@extends('layouts.app')

@section('title', 'Detalle de la venta')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="table-responsive">
					<div class="row p-3">
                        <div class="col-6">
							Cliente: {{$sales->customerName }}
							<br>
							Documento: {{ $sales->document }}
						</div>
						<div class="col-6">
							Fecha: {{ $sales->sale_date }}
							<br>
							N.factura: {{ $sales->id }}
						</div>
						
					</div>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID del Producto</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                         <tbody>
                            @foreach ($details as $detail)
                                <tr>
                                    <td>{{ $detail->productName }}</td>
                                    <td>${{ ($detail->productPrice) }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>${{($detail->subtotal) }}</td>
                                </tr>
                            @endforeach
                            
                            

                        </tbody> 
                        
                    </table>
                    <div class="col-6">
                        Total: ${{ $sales->total_sale }}
                    </div>
                </div>
                <br>
                <div class="col-2">
                <a href="{{ route('sales.index') }}" class="btn btn-danger btn-block">Atras</a>
                </div>
            </div>
        </section>
    </div>
@endsection