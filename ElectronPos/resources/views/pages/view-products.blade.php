<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#productsTable').DataTable();
    });
</script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Products"></x-navbars.navs.auth>
        <!-- End Navbar -->
        @if(!$products)
        <h1>No Products Found</h1>
        @endif
        <script>
           function generatePDF() {
    var doc = new jsPDF();

    // Title
    doc.setFontSize(12);
    doc.text('Available Products', 10, 10);

    // Table
    var htmlContent = document.getElementById('productsTable').innerHTML;
    doc.fromHTML(htmlContent, 10, 20, {
        width: 180
    });

    // Save the PDF
    doc.save('AvailableProducts.pdf');
}
            </script>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Products</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Products {{$productCount}}</h6>
                            </div>
                            <hr>
                            <button onclick="generatePDF()" class = "btn btn-info"><i class = "fa fa-print"></i>Generate PDF</button>
                            <a class="btn btn-danger" href="{{ route('create-product') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">Add New Product</span>
                            </a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 table-hover" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                                Barcode</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                                Product Name</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Description</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Cost Price</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Selling Price</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Unit Of Measurement</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Created At</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Updated At</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Edit Product</th> 
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Delete Product</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$product->barcode}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$product->name}}</p>
                                            </td>
                                           
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$product->description}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$product->price}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$product->selling_price}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$product->unit_of_measurement}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$product->created_at}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{$product->updated_at}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('edit-product',$product->id) }}">Edit Product</a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('delete-product',$product->id) }}">Delete Product</a>
                                            </td>             
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$products->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
