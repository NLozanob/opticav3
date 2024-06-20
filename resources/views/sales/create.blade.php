@extends('layouts.app')

@section('title', 'Registrar Venta')

@section('content')
<div class="content-wrapper" style="background-color: #427D9D">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header" style="background-color: #427D9D">
                                <h3>@yield('title')</h3>
                            </div>
                            <form method="POST" action="{{ route('sales.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body" id="form-fields">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Cliente<strong style="color:red;">(*)</strong></label>
                                                <select class="form-control select2" name="customer" id="customer">
                                                    <option value="-1">Elegir cliente</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} ({{ $customer->identification_document }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" class="form-control" name="status" value="1">
                                            <input type="hidden" class="form-control" name="registered_by"
                                                value="{{ Auth::user()->id }}">
                                        </div>
                                    </div>

                                    <div class="row mt-2" data-details-field="true">
                                        <div class="col-3">
                                            <select id="product" class="form-control">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}" data-name="{{ $product->name }}">
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="quantity">Cantidad</label>
                                            <input type="number" id="quantity" class="quantity-input form-control">
                                        </div>
                                        <div class="col-2">
                                            <label for="price">Precio</label>
                                            <input type="number" id="price" class="price-input form-control" readonly>
                                        </div>
                                        <div class="col-2">
                                            <label for="subtotal">Subtotal</label>
                                            <input type="number" id="subtotal" class="subtotal-input form-control" readonly>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-block" id="add-btn" style="background-color: #40A578;">ADD</button>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio</th>
                                                        <th>Subtotal</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list-products"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <span class="h3 d-block text-center m-1" id="total-text">Total: $0</span>
                                        </div>
                                        <input name="total_sale" type="hidden" id="total-sale">
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-block" style="background-color: #40A578;">Registrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-2">
                            <a href="{{ route('sales.index') }}" class="btn btn-danger btn-block">Atras</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .select2 [role="textbox"] {
            margin-top: -8px !important;
            margin-left: -8px !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
    function generateHTML(productId, name, quantity, price, subtotal) {
        return `
            <tr>
                <td>${name}</td>
                <td>${quantity}</td>
                <td>$${price}</td>
                <td>$${subtotal}</td>
                <td><button type="button" class="btn btn-danger btn-remove">Remove</button></td>
                <input type="hidden" name="product_id[]" value="${productId}">
                <input type="hidden" name="quantity[]" value="${quantity}">
                <input type="hidden" name="purchase_price[]" value="${price}">
                <input type="hidden" name="subtotal[]" value="${subtotal}">
            </tr>
        `;
    }

    $(document).ready(function() {
        let listProducts = $('#list-products');
        let addButton = $('#add-btn');
        let productSelect = $('#product');
        let productPrice = $('#price');
        let productQuantity = $('#quantity');
        let productSubtotal = $('#subtotal');
        let totalText = $('#total-text');
        let totalInput = $('#total-sale');
        let total = 0;

        productSelect.select2();
        updateSubtotal();

        addButton.on("click", function() {
            let productId = productSelect.val();
            let quantity = parseInt(productQuantity.val());
            let price = parseFloat(productPrice.val());
            let subtotal = quantity * price;
            let name = productSelect.find(':selected').data('name');

            total += subtotal;
            totalText.text(`Total: $${total.toFixed(2)}`);
            totalInput.val(total.toFixed(2));

            let newRow = $(generateHTML(productId, name, quantity, price.toFixed(2), subtotal.toFixed(2)));
            newRow.find('.btn-remove').on('click', function() {
                let row = $(this).closest('tr');
                let rowSubtotal = parseFloat(row.find('td').eq(3).text().replace('$', ''));
                total -= rowSubtotal;
                totalText.text(`Total: $${total.toFixed(2)}`);
                totalInput.val(total.toFixed(2));
                row.remove();
            });

            listProducts.append(newRow);
            productQuantity.val('');
            productSubtotal.val('');
        });

        function updateSubtotal() {
            let quantity = parseInt(productQuantity.val()) || 0;
            let price = parseFloat(productSelect.find(':selected').data('price')) || 0;
            let subtotal = quantity * price;
            productPrice.val(price.toFixed(2));
            productSubtotal.val(subtotal.toFixed(2));
        }

        productSelect.on('select2:select', updateSubtotal);
        productQuantity.on('input', updateSubtotal);
    });
    </script>
    <!-- SCRIPT TO SELECT CLIENT -->
<script type="text/javascript">
    $("#customer").select2({
        allowClear: true
    });
</script>
@endpush