@extends('layouts.layoutMaster')

@section('title', 'Notification List - Pages')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <div class="card" style="width: -webkit-fill-available;">
        <div class="card-body">
            <!-- Your existing card content -->

            <!-- Notifications List -->
            <div class="container mt-4">
                <h3>All Notifications</h3>
                <ul class="list-group">
                    @forelse($notifications as $notification)
                        @php

                            $string = $notification->data;
                            preg_match('/Delivery(\d+)/', $string, $matches);
                            $deliveryNumber = isset($matches[1]) ? $matches[1] : null;
                            $user = App\Models\User::find($deliveryNumber);
                            if(strcmp($notification->notifiable_type,"App\Models\order")){
                              $route = route("storeorders.show", ["storeorder" => $notification->notifiable_id]);
                            }elseif(strcmp($notification->notifiable_type ,"App\Models\OrderButler")){
                              $route = route("orderbutlers.show",["orderbutler"=>$notification->notifiable_id]);
                            }else{
                              $route = route("ordercallcenters.show",["ordercallcenter"=>$notification->notifiable_id]);
                            }
                        @endphp

                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <a href="{{ route('deliveries.show', ['delivery' => $deliveryNumber]) }}">
                                            <img src="{{ $user->image }}" alt="User Avatar" class="h-auto rounded-circle">
                                        </a>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $notification->title }} </h6>
                                    <p class="mb-0"><a href="{{ $route }}">{{ $notification->data }}</a></p>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="flex-shrink-0">
                                    <!-- Additional actions or buttons if needed -->
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">
                            <p class="mb-0">No notifications available.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
            <!-- End Notifications List -->
        </div>
    </div>
</div>
@endsection
