@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Stock</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('all.product') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Sold Products</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('sold.products') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Available Products</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('available.products') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Pending Orders</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('pending.orders') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-10">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Monthly Sales Chart
                    </div>
                    <div class="card-body"><canvas id="monthlySalesChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Recent Customer Sales
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Company</th>
                                <th>Address</th>
                                <!-- <th>Total_Price</th> -->
                                <th>Product Name</th>
                                <!-- <th>Sales Stock Price</th> -->
                                <th>Quantity</th>
                                <th>Total Cost</th>
                                <th>Due</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->customer_name }}</td>
                                <td>{{ $row->customer_mail }}</td>
                                <td>{{ $row->company }}</td>
                                <td>{{ $row->address }}</td>
                                <td>{{ $row->product_name }}</td>
                                <td>{{ $row->quantity }}</td>
                                <td>{{ $row->total }}</td>
                                <td>{{ $row->due }}</td>
                                <td>{{ $row->created_at }}</td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

<script>
    // Get monthly sales data from PHP variable
    var monthlySalesData = @json($monthlySalesData);

    // Prepare an array to hold sales data for all months (initialize with zeros)
    var salesData = Array.from({ length: 12 }, () => 0);

    // Fill in sales data for available months
    monthlySalesData.forEach(function(item) {
        salesData[item.month - 1] = item.total_sales; // Month is 1-indexed
    });

    // Labels for all months (January to December)
    var months = [
        'January', 'February', 'March', 'April', 'May', 'June', 'July',
        'August', 'September', 'October', 'November', 'December'
    ];

    // Render the chart
    var ctx = document.getElementById('monthlySalesChart').getContext('2d');
    var monthlySalesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Sales',
                data: salesData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>