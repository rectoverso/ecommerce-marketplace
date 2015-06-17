@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12" id="banner-home-user">
                <h1>Welcome, {{ current_user()->name }}</h1>
            </div>
        </div>
    </div>

    <div id="home-user">
        <div class="container" id="home-user-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active" style="z-index: 3">
                    <a href="#dashboard"
                       aria-controls="dashboard"
                       role="tab"
                       data-toggle="tab">Dashboard</a>
                </li>
                <li role="presentation" style="z-index: 2">
                    <a href="#orders"
                       aria-controls="orders"
                       role="tab"
                       data-toggle="tab">Your orders</a>
                </li>
                <li role="presentation" style="z-index: 1">
                    <a href="#details"
                       aria-controls="details"
                       role="tab"
                       data-toggle="tab">Your details</a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="dashboard">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <h3>Your recent orders</h3>

                            <div class="row">
                                @foreach($orders as $order)
                                    <div class="col-xs-6">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <span class="glyphicon glyphicon-time"></span>
                                                {{ $order->created_at->format('jS \of F \a\t H:i') }}
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    <i class="fa fa-coffee"></i>

                                                    @foreach($order->order_lines as $i => $line)
                                                        {{ $order->coffee_shop->getNameFor($line->product) . ($i + 1 !== count($order->order_lines) ? ', ' : '')  }}
                                                    @endforeach
                                                </p>

                                                <p>
                                                    <span class="glyphicon glyphicon-map-marker"></span>
                                                    {{ $order->coffee_shop->location }}
                                                </p>
                                            </div>
                                            <div class="panel-footer">
                                                Total: <span class="pull-right">£ {{ $order->price }}</span>
                                            </div>
                                            <div class="panel-footer">
                                                <a href="#" class="btn btn-primary">Re-Order</a>
                                                <a href="#" class="btn btn-warning">Leave Review</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-12 col-md-4">
                            <h3>Your offers</h3>

                            @foreach(current_user()->offers->unique()->take(4) as $i => $offer)
                                @include('offers._short', ['bgNum' => $i % 4 + 1])
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <h3>Recommended coffee shops for you</h3>

                            <div class="row">
                                @foreach(current_user()->coffee_shops->unique()->take(6) as $coffeeShop)
                                    <div class="col-xs-6 col-sm-4">
                                        <div class="featured-coffee-shop" style="background-image: url({{$coffeeShop->mainImage() }})">
                                            <div class="info small-featured">
                                                <h5>
                                                    {{ $coffeeShop->name }}
                                                    <div class="pull-right">
                                                        @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])
                                                    </div>
                                                </h5>
                                                <p>
                                                    <i>{{ $coffeeShop->location }}</i>
                                                </p>
                                                <div class="actions text-center">
                                                    <a href="{{ route('coffee-shop.order.create', ['coffeeShop' => $coffeeShop]) }}"
                                                       class="btn btn-success">Order <span class="hidden-xs"> a Coffee </span></a>
                                                    <a href="{{ route('coffee-shop.show', ['coffeeShop' => $coffeeShop]) }}"
                                                       class="btn btn-primary">View <span class="hidden-xs">Profile</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="orders">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-hovered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->created_at }}</td>
                                        <td>£ {{ number_format($order->price / 100., 2) }}</td>
                                        <td>
                                            <a href="{{ route('order.success', ['order' => $order]) }}"
                                               class="btn btn-primary btn-xs">
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="details">
                    <h3>Your details</h3>

                    <dl class="dl-horizontal">
                        <dt>Name</dt>
                        <dd>{{ current_user()->name }}</dd>
                        <dt>Email</dt>
                        <dd>{{ current_user()->email }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
