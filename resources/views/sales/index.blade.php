@extends('layouts.app')

@section('title','Listado de ventas')

@section('content')

<div class="content-wrapper" style="background-color: #427D9D">
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem; background-color: #427D9D;">
                            @yield('title')
                                <a href="{{ route('sales.create') }}" class="btn btn-primary float-right" title="Create"><i class="fas fa-plus nav-icon"></i></a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Cliente</th>
                                        <th>ID Cliente</th>
                                        <th>Fecha de la venta</th>
                                        <th>Total de la venta</th>
                                        <th>Estado</th>
                                        <th>Registrado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                            @foreach ($sales as $sale)
                                                <tr>
                                                    <td>{{ $sale->id }}</td>
                                                    <td>
                                                        
                                                            {{ $sale->first_name }}
                                                       
                                                    </td>
                                                    <td>
                                                       
                                                            {{ $sale->identification_document }}
                                                        
                                                    </td>
                                                    <td>{{ $sale->sale_date }}</td>
                                                    
                                                    <td>{{ $sale->total_sale }}</td>
                                                    <td>
                                                        <input data-id="{{ $sale->id }}" class="toggle-class"
                                                            type="checkbox" data-onstyle="success" data-offstyle="danger"
                                                            data-toggle="toggle" data-on="Activo" data-off="Inactivo"
                                                            {{ $sale->status ? 'checked' : '' }}>
                                                    </td>
                                                    <td>{{ $sale->registered_by }}</td>
                                                   
                                                    <td>
                                                        <a target="_blank" href="{{ route('sale.pdf', $sale->id) }}" class="btn btn-primary btn-sm" title="Download bill">
                                                            <i class="fa-solid fa-file-pdf"></i>
                                                        </a>
                                                        <form class="d-inline delete-form"
                                                            action="{{ route('sales.destroy', $sale->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                        </form>
                                                        
                                                        <a href="{{ route('sales.show', $sale) }}"
                                                        class="btn btn-primary btn-sm" title="View">
                                                        <i class="fa-solid fa-eye"></i>

                                                        
                                                    </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 </div>
@endsection

@push('scripts')
	<script>
		$(document).ready(function(){
			$("example1").DataTable()
		});
		$(function() {
			$('.toggle-class').change(function() {
				var status = $(this).prop('checked') == true ? 1 : 0;
				var customer_id = $(this).data('id');
				$.ajax({
					type: "GET",
					dataType: "json",
					url: 'changestatuscustomer',
					data: {'status': status, 'customer_id': customer_id},
					success: function(data){
					  console.log(data.success)
					}
				});
			})
		  })
	</script>
	<script>
	$('.delete-form').submit(function(e){
		e.preventDefault();
		Swal.fire({
			title: '¿Estás seguro?',
			text: "Este registro se eliminará de forma permanente",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Acceptar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				this.submit();
			}
		})
	});
	</script>
	@if(session('delete') == 'ok')
		<script>
			Swal.fire(
				'Deleted',
				'El registro se ha eliminado correctamente',
				'success'
			)
		</script>
	@endif
	<script type="text/javascript">
		$(function () {
			$("#example1").DataTable({
				"responsive": true, 
				"lengthChange": true, 
				"autoWidth": false,
				//"buttons": ["excel", "pdf", "print", "colvis"],
				"language": 
						{
							"sLengthMenu": "Mostrar _MENU_ Entradas",
							"sEmptyTable": "No hay datos disponibles en la tabla",
							"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
							"sInfoEmpty": "Mostrando 0 a 0 de 0 Entradas",
							"sSearch": "Buscar:",
							"sZeroRecords": "No se encontraron registros coincidentes en la tabla",
							"sInfoFiltered": "(Filtrado de _MAX_ Entradas totales)",
							"oPaginate": {
								"sFirst": "Primero",
								"sPrevious": "Anterior",
								"sNext": "Próximo",
								"sLast": "Ultimo"
							},
							/*"buttons": {
								"print": "Imprimir",
								"colvis": "Visibilidad Columnas"
								/*"create": "Nuevo",
								"edit": "Cambiar",
								"remove": "Borrar",
								"copy": "Copiar",
								"csv": "fichero CSV",
								"excel": "tabla Excel",
								"pdf": "documento PDF",
								"collection": "Colección",
								"upload": "Seleccione fichero...."
							}*/
						}
			});//.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		});
	</script>
@endpush
