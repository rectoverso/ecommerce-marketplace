@extends('app')

@section('page-title')
    List coffee shops
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    @yield('page-title')
                    <span id="page-actions" class="admin">
                        <a href="{{ route('admin.home') }}" class="btn btn-primary">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Product management</a>
                        <a href="{{ route('admin.coffee-shop.index') }}" class="btn btn-primary">Coffee Shops</a>
                        <a href="{{ route('admin.sales') }}" class="btn btn-primary">Sales</a>
                        <a href="{{ route('admin.reporting') }}" class="btn btn-primary">Reporting</a>
                        <a href="{{ route('admin.export') }}" class="btn btn-primary">Export</a>
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">Customers</a>
                        <a href="{{ route('admin.post.index') }}" class="btn btn-primary">All posts</a>
                    </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th># products</th>
                        <th>Sales</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shops as $shop)
                        <tr>
                            <td>{{ $shop->name }}</td>
                            <td>{{ $shop->location }}</td>
                            <td>#</td>
                            <td>#</td>
                            <td>
                                <a href="{{ route('admin.coffee-shop.show', ['coffee_shop' => $shop]) }}"
                                   class="btn btn-xs btn-default">Details</a>
                                <a href="{{ route('admin.coffee-shop.edit', ['coffee_shop' => $shop]) }}"
                                   class="btn btn-xs btn-primary">Edit</a>
                                @if($shop->isPublished())
                                    <a href="{{ route('admin.coffee-shop.featured', ['coffee_shop' => $shop]) }}"
                                       class="btn btn-xs btn-{{$shop->featured ? 'warning' : 'success'}}">
                                        {{$shop->featured ? 'Unset ' : 'Set as '}} featured
                                    </a>
                                @else
                                    <span class="btn btn-xs btn-default disabled">Not published yet</span>
                                @endif
                                @if ($shop->status != 'denied')
                                    <a href="{{ route('admin.coffee-shop.destroy', ['coffee_shop' => $shop]) }}"
                                       class="btn btn-xs btn-danger"
                                       data-confirm="Are you sure you want to do that?"
                                       data-method="delete">Disable</a>
                                @elseif ($shop->status == 'published')
                                    <a href="{{ route('admin.coffee-shop.enable', ['coffee_shop' => $shop]) }}"
                                        class="btn btn-xs btn-primary"
                                        data-method="enable">Enable</a>
                                @endif
                                    <a href="{{ route('admin.coffee-shop.delete', ['coffee_shop' => $shop]) }}"
                                        class="btn btn-xs btn-primary pull-right"
                                        data-method="delete">Delete</a>  

                            </td>
                        </tr>
    
                    @endforeach
                    </tbody>
                </table>
                <div class="pull-right">
                    {!! $shops->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
