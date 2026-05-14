@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<style>
:root{
    --primary:#e1206b;
    --primary-light:#fff0f5;
    --bg:#f7f8fc;
    --border:#f1f1f1;
}

.dashboard-wrapper{
    padding:10px 15px;
}

.dashboard-title{
    font-size:24px;
    font-weight:700;
    margin-bottom:20px;
}

/* =========================
    STATS
========================= */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.stats-card{
    background:#fff;
    border-radius:18px;
    padding:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border:1px solid #f3f3f3;
    box-shadow:0 2px 10px rgba(0,0,0,0.04);
}

.stats-left{
    display:flex;
    align-items:center;
    gap:14px;
}

.stats-icon{
    width:58px;
    height:58px;
    border-radius:16px;
    background:var(--primary-light);
    color:var(--primary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.stats-content h2{
    margin:0;
    font-size:28px;
    font-weight:700;
}

.stats-content p{
    margin:0;
    font-weight:600;
}

.stats-content small{
    color:#888;
}

/* =========================
    SECTION
========================= */

.section-card{
    background:#fff;
    border-radius:18px;
    padding:18px;
    margin-bottom:20px;
    border:1px solid #f3f3f3;
    box-shadow:0 2px 10px rgba(0,0,0,0.04);
}

.section-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.section-header h4{
    margin:0;
    font-size:20px;
    font-weight:700;
}

/* =========================
    LIST
========================= */

.list-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 0;
    border-top:1px solid var(--border);
}

.list-left{
    display:flex;
    align-items:center;
    gap:14px;
}

.list-avatar img,
.product-image img{
    width:60px;
    height:60px;
    border-radius:14px;
    object-fit:cover;
}

.list-content h5{
    margin:0;
    font-size:16px;
    font-weight:700;
}

.list-content p{
    margin:2px 0;
    font-size:13px;
    color:#666;
}

.price{
    color:var(--primary);
    font-weight:700;
}

.list-actions{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.badge-pending{
    background:#fff2d8;
    color:#d48a00;
    padding:6px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.btn-custom{
    border:none;
    padding:8px 16px;
    border-radius:10px;
    font-weight:600;
    font-size:13px;
    cursor:pointer;
    transition:0.3s;
}

.btn-view{
    border:1px solid var(--primary);
    background:#fff;
    color:var(--primary);
}

.btn-view:hover{
    background:var(--primary);
    color:#fff;
}

.btn-approve{
    background:linear-gradient(135deg,#e1206b,#ff4d94);
    color:#fff;
}

.btn-approve:hover{
    opacity:0.9;
}

/* =========================
    MODAL
========================= */

.modal-content{
    border:none;
    border-radius:24px;
    overflow:hidden;
}

.modal-header{
    background:linear-gradient(135deg,#e1206b,#ff4d94);
    color:#fff;
    border:none;
}

.modal-image{
    width:100%;
    height:300px;
    object-fit:cover;
    border-radius:18px;
}

.modal-info h3{
    font-size:28px;
    font-weight:700;
    margin-bottom:15px;
}

.modal-info p{
    margin-bottom:10px;
    color:#666;
}

.modal-label{
    font-weight:700;
    color:#222;
}

.modal-footer{
    border:none;
}

.btn-modal-close{
    background:#f3f3f3;
    border:none;
    padding:10px 20px;
    border-radius:12px;
}

.btn-modal-approve{
    background:linear-gradient(135deg,#e1206b,#ff4d94);
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:12px;
    font-weight:700;
}

.activity-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
}

.activity-card{
    display:flex;
    gap:12px;
}

.activity-icon{
    width:48px;
    height:48px;
    border-radius:50%;
    background:var(--primary-light);
    color:var(--primary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
}

.activity-content h6{
    margin:0;
    font-weight:700;
}

.activity-content p{
    margin:0;
    font-size:13px;
    color:#777;
}

.custom-status-badge{
    padding:7px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:700;
}

/* Pending */
.status-pending{
    background:#fff1db;
    color:#d68900;
}

/* Approved */
.status-approved{
    background:#e8fff1;
    color:#11a75c;
}

/* Rejected */
.status-rejected{
    background:#ffe8e8;
    color:#df2b2b;
}

/* Active */
.status-active{
    background:#ffe5f0;
    color:#e1206b;
}

/* Inactive */
.status-inactive{
    background:#f1f1f1;
    color:#666;
}

/* Default */
.status-default{
    background:#f1f1f1;
    color:#666;
}

.empty-state{
    padding:40px 20px;
    text-align:center;
}

.empty-icon{
    width:80px;
    height:80px;
    margin:auto;
    border-radius:50%;
    background:#fff0f5;
    color:#e1206b;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    margin-bottom:18px;
}

.empty-state h5{
    font-size:18px;
    font-weight:700;
    margin-bottom:8px;
    color:#222;
}

.empty-state p{
    color:#888;
    font-size:14px;
    margin:0;
}
</style>

<div class="dashboard-wrapper">

    <h2 class="dashboard-title">Dashboard</h2>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stats-card">
            <div class="stats-left">
                <div class="stats-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stats-content">
                    <h2>{{ $totalSellers }}</h2>
                    <p>New Sellers</p>
                    <small>Pending Approval</small>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-left">
                <div class="stats-icon">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <div class="stats-content">
                    <h2>{{ $totalServiceProviders }}</h2>
                    <p>Service Providers</p>
                    <small>Pending Approval</small>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-left">
                <div class="stats-icon">
                    <i class="fa-solid fa-box"></i>
                </div>
                <div class="stats-content">
                    <h2>{{ $totalProducts }}</h2>
                    <p>Products</p>
                    <small>Pending Approval</small>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-left">
                <div class="stats-icon">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div class="stats-content">
                    <h2>{{ $totalServices }}</h2>
                    <p>Services</p>
                    <small>Pending Approval</small>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW 1 --}}
    <div class="row">

        {{-- SELLERS --}}
        <div class="col-lg-6">

            <div class="section-card">

                <div class="section-header">
                    <h4>New Sellers</h4>
                </div>
                @if($newSellers->count() > 0)
                    @foreach($newSellers as $seller)

                        <div class="list-item">

                            <div class="list-left">

                                <div class="list-avatar">

                                    <img src="{{ $seller->image
                                            ? asset($seller->image)
                                            : asset('admin-panel-image/WoomenSquareFlat.png') }}">

                                </div>

                                <div class="list-content">

                                    <h5>{{ $seller->name }}</h5>

                                    <p>{{ $seller->email }}</p>

                                    <p>{{ $seller->mobile }}</p>

                                </div>

                            </div>

                            <div class="list-actions">

                                @php

                                    $status = (int) $seller->status;

                                    $statusClass = match($status){
                                        0 => 'status-pending',
                                        1 => 'status-approved',
                                        2 => 'status-rejected',
                                        3 => 'status-blocked',
                                        4 => 'status-inactive',
                                        default => 'status-default'
                                    };

                                    $statusText = match($status){
                                        0 => 'Pending',
                                        1 => 'Approved',
                                        2 => 'Rejected',
                                        3 => 'Blocked',
                                        4 => 'Inactive',
                                        default => 'Unknown'
                                    };

                                @endphp

                                <span class="custom-status-badge {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>

                                <button class="btn-custom btn-view"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sellerModal{{ $seller->id }}">
                                    View
                                </button>

                                @if($seller->status != 1)

                                    <form action="{{ route('admin.seller.approve',$seller->id) }}"
                                        method="POST">

                                        @csrf

                                        <button class="btn-custom btn-approve">
                                            Approve
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                        {{-- SELLER MODAL --}}
                        <div class="modal fade"
                            id="sellerModal{{ $seller->id }}"
                            tabindex="-1">

                            <div class="modal-dialog modal-lg modal-dialog-centered">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title">
                                            Seller Details
                                        </h5>

                                        <button type="button"
                                                class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>

                                    </div>

                                    <div class="modal-body">

                                        <div class="row align-items-center">

                                            <div class="col-md-4 text-center">

                                                <img src="https://ui-avatars.com/api/?name={{ $seller->name }}&background=e1206b&color=fff"
                                                    class="modal-image">

                                            </div>

                                            <div class="col-md-8">

                                                <div class="modal-info">

                                                    <h3>{{ $seller->name }}</h3>

                                                    <p>
                                                        <span class="modal-label">Email :</span>
                                                        {{ $seller->email }}
                                                    </p>

                                                    <p>
                                                        <span class="modal-label">Mobile :</span>
                                                        {{ $seller->mobile }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button"
                                                class="btn-modal-close"
                                                data-bs-dismiss="modal">
                                            Close
                                        </button>

                                        <form action="{{ route('admin.seller.approve',$seller->id) }}"
                                            method="POST">

                                            @csrf

                                            <button class="btn-modal-approve">
                                                Approve Seller
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach
                @else
                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <h5>No New Sellers</h5>

                        <p>
                            No pending seller available right now.
                        </p>

                    </div>

                @endif

            </div>

        </div>

        {{-- SERVICE PROVIDERS --}}
        <div class="col-lg-6">

            <div class="section-card">

                <div class="section-header">
                    <h4>Service Providers</h4>
                </div>
                @if($newServiceProviders->count() > 0)
                    @foreach($newServiceProviders as $provider)

                    <div class="list-item">

                        <div class="list-left">

                            <div class="list-avatar">

                                <img src="{{ $provider->image
                                        ? asset($provider->image)
                                        : asset('admin-panel-image/WoomenSquareFlat.png') }}">

                            </div>

                            <div class="list-content">

                                <h5>{{ $provider->name }}</h5>

                                <p>{{ $provider->email }}</p>

                                <p>{{ $provider->mobile }}</p>

                            </div>

                        </div>

                        <div class="list-actions">

                            @php

                                $status = (int) $provider->status;

                                $statusClass = match($status){
                                    0 => 'status-pending',
                                    1 => 'status-approved',
                                    2 => 'status-rejected',
                                    3 => 'status-blocked',
                                    4 => 'status-inactive',
                                    default => 'status-default'
                                };

                                $statusText = match($status){
                                    0 => 'Pending',
                                    1 => 'Approved',
                                    2 => 'Rejected',
                                    3 => 'Blocked',
                                    4 => 'Inactive',
                                    default => 'Unknown'
                                };

                            @endphp

                            <span class="custom-status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>

                            <button class="btn-custom btn-view"
                                    data-bs-toggle="modal"
                                    data-bs-target="#providerModal{{ $provider->id }}">
                                View
                            </button>

                            @if($provider->status != 1)

                                <form action="{{ route('admin.seller.approve',$provider->id) }}"
                                    method="POST">

                                    @csrf

                                    <button class="btn-custom btn-approve">
                                        Approve
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                    @endforeach
                @else
                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>

                        <h5>No services provider</h5>

                        <p>
                            No pending services providers right now.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

    {{-- ROW 2 --}}
    <div class="row">

        {{-- PRODUCTS --}}
        <div class="col-lg-6">

            <div class="section-card">

                <div class="section-header">
                    <h4>New Products</h4>
                </div>
                @if($latestProducts->count() > 0)
                    @foreach($latestProducts as $product)

                        <div class="list-item">

                            <div class="list-left">

                                <div class="product-image">
                                    <img src="{{ $product->image }}">
                                </div>

                                <div class="list-content">

                                    <h5>{{ $product->name }}</h5>

                                    <p>
                                        Seller :
                                        {{ $product->seller->name ?? '-' }}
                                    </p>

                                    <p class="price">
                                        ₹ {{ $product->selling_price }}
                                    </p>

                                </div>

                            </div>

                            <div class="list-actions">

                                @php

                                    $statusClass = match($product->status){
                                        0 => 'status-inactive',
                                        1 => 'status-active',
                                        2 => 'status-pending',
                                        3 => 'status-approved',
                                        4 => 'status-rejected',
                                        default => 'status-default'
                                    };

                                    $statusText = match($product->status){
                                        0 => 'Inactive',
                                        1 => 'Active',
                                        2 => 'Pending',
                                        3 => 'Approved',
                                        4 => 'Rejected',
                                        default => 'Unknown'
                                    };

                                @endphp

                                <span class="custom-status-badge {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>

                                <button class="btn-custom btn-view"
                                        data-bs-toggle="modal"
                                        data-bs-target="#productModal{{ $product->id }}">
                                    View
                                </button>

                                @if($product->status != 3)

                                    <form action="{{ route('admin.products.approve',$product->id) }}"
                                        method="POST">

                                        @csrf

                                        <button class="btn-custom btn-approve">
                                            Approve
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                        {{-- PRODUCT MODAL --}}
                        <div class="modal fade"
                            id="productModal{{ $product->id }}"
                            tabindex="-1">

                            <div class="modal-dialog modal-lg modal-dialog-centered">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title">
                                            Product Details
                                        </h5>

                                        <button type="button"
                                                class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>

                                    </div>

                                    <div class="modal-body">

                                        <div class="row align-items-center">

                                            <div class="col-md-5">

                                                <img src="{{ $product->image }}"
                                                    class="modal-image">

                                            </div>

                                            <div class="col-md-7">

                                                <div class="modal-info">

                                                    <h3>{{ $product->name }}</h3>

                                                    <p>
                                                        <span class="modal-label">Brand :</span>
                                                        {{ $product->brand_name }}
                                                    </p>

                                                    <p>
                                                        <span class="modal-label">Price :</span>
                                                        ₹ {{ $product->selling_price }}
                                                    </p>

                                                    <p>
                                                        <span class="modal-label">Stock :</span>
                                                        {{ $product->stock }}
                                                    </p>

                                                    <p>
                                                        <span class="modal-label">Description :</span>
                                                        {{ $product->desc }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button"
                                                class="btn-modal-close"
                                                data-bs-dismiss="modal">
                                            Close
                                        </button>

                                        <form action="{{ route('admin.products.approve',$product->id) }}"
                                            method="POST">

                                            @csrf

                                            <button class="btn-modal-approve">
                                                Approve Product
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach
                @else
                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-box-open"></i>
                        </div>

                        <h5>No New Product</h5>

                        <p>
                            No pending product available right now.
                        </p>

                    </div>

                @endif

            </div>

        </div>

        {{-- SERVICES --}}
        <div class="col-lg-6">

            <div class="section-card">

                <div class="section-header">
                    <h4>New Services</h4>
                </div>
                    @if($latestServices->count() > 0)
                        @foreach($latestServices as $service)

                            <div class="list-item">

                                <div class="list-left">

                                    <div class="product-image">
                                        <img src="{{ $service->image }}">
                                    </div>

                                    <div class="list-content">

                                        <h5>{{ $service->service_title }}</h5>

                                        <p>
                                            Provider :
                                            {{ $service->serviceProviderDetail->name ?? '-' }}
                                        </p>

                                        <p class="price">
                                            ₹ {{ $service->price }}
                                        </p>

                                    </div>

                                </div>

                                <div class="list-actions">

                                    @php
                                        $status = (int) $service->status;
                                        $statusClass = match($status){
                                            0 => 'status-inactive',
                                            1 => 'status-active',
                                            2 => 'status-pending',
                                            3 => 'status-approved',
                                            4 => 'status-rejected',
                                            default => 'status-default'
                                        };

                                        $statusText = match($status){
                                            0 => 'Inactive',
                                            1 => 'Active',
                                            2 => 'Pending',
                                            3 => 'Approved',
                                            4 => 'Rejected',
                                            default => 'Unknown'
                                        };

                                    @endphp

                                    <span class="custom-status-badge {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>

                                    <button class="btn-custom btn-view"
                                            data-bs-toggle="modal"
                                            data-bs-target="#serviceModal{{ $service->id }}">
                                        View
                                    </button>

                                    @if($service->status != 3)

                                        <form action="{{ route('admin.services.approve',$service->id) }}"
                                            method="POST">

                                            @csrf

                                            <button class="btn-custom btn-approve">
                                                Approve
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </div>

                            {{-- SERVICE MODAL --}}
                            <div class="modal fade"
                                id="serviceModal{{ $service->id }}"
                                tabindex="-1">

                                <div class="modal-dialog modal-lg modal-dialog-centered">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Service Details
                                            </h5>

                                            <button type="button"
                                                    class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>

                                        </div>

                                        <div class="modal-body">

                                            <div class="row align-items-center">

                                                <div class="col-md-5">

                                                    <img src="{{ $service->image }}"
                                                        class="modal-image">

                                                </div>

                                                <div class="col-md-7">

                                                    <div class="modal-info">

                                                        <h3>{{ $service->service_title }}</h3>

                                                        <p>
                                                            <span class="modal-label">Category :</span>
                                                            {{ $service->service_category }}
                                                        </p>

                                                        <p>
                                                            <span class="modal-label">Price :</span>
                                                            ₹ {{ $service->price }}
                                                        </p>

                                                        <p>
                                                            <span class="modal-label">Experience :</span>
                                                            {{ $service->experience }}
                                                        </p>

                                                        <p>
                                                            <span class="modal-label">Description :</span>
                                                            {{ $service->service_desc }}
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button type="button"
                                                    class="btn-modal-close"
                                                    data-bs-dismiss="modal">
                                                Close
                                            </button>

                                            <form action="{{ route('admin.services.approve',$service->id) }}"
                                                method="POST">

                                                @csrf

                                                <button class="btn-modal-approve">
                                                    Approve Service
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach
                    @else
                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="fa-solid fa-gears"></i>
                            </div>

                            <h5>No New Services</h5>

                            <p>
                                No pending services available right now.
                            </p>

                        </div>
                    @endif

            </div>

        </div>

    </div>
</div>

@endsection