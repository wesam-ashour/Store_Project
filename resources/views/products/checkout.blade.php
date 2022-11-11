@extends('layouts.master')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Checkout</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="#">Home</a></li>
                        <li class="active">Checkout</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <form role="form" action="{{ route('stripe.post') }}" method="post" data-cc-on-file="false"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                    @csrf
                    <div class="col-md-7">
                        <!-- Billing Details -->
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">Billing address</h3>
                            </div>
                            <div class="form-group">
                                <label>First name</label>
                                <label></label>
                                <input class="input" type="text" value="{{ auth()->user()->first_name }}" disabled
                                    placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label>Last name</label>
                                <input class="input" type="text" value="{{ auth()->user()->last_name }}" disabled
                                    placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="input" type="email" value="{{ auth()->user()->email }}" disabled
                                    placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <select name="address" class="form-control">
                                    @forelse ($addresss as $address)
                                        <option value="{{ $address->id }}">{{ $address->street_no }}
                                        </option>
                                    @empty
                                        No address found
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="order-notes">
                            <label>Notes</label>
                            <textarea class="input" name="notes" placeholder="Order Notes"></textarea>
                        </div>
                        <!-- /Order notes -->
                    </div>

                    <!-- Order Details -->
                    <div class="col-md-5 order-details">
                        <div class="section-title text-center">
                            <h3 class="title">Your Order</h3>
                        </div>
                        <div class="order-summary">
                            <div class="order-col">
                                <div><strong>PRODUCT</strong></div>
                                <div><strong>TOTAL</strong></div>
                            </div>
                            <div class="order-products">
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($oldCart as $id => $item)
                                    <div class="order-col">
                                        <div><?php $sum = 0; ?>
                                            @foreach ($item['color_items'] as $key => $c)
                                                <?php $sum += $c['quantity']; ?>
                                            @endforeach {{ $sum }}x
                                            {{ \App\Models\Product::find($item['id'])->title }}
                                        </div>
                                        <div>${{ \App\Models\Product::find($item['id'])->offer_price * $sum }}</div>
                                    </div>
                                    @php $total += \App\Models\Product::find($item['id'])->offer_price * $sum @endphp
                                @endforeach
                            </div>
                            <div class="order-col">
                                <div>Shiping</div>
                                <div><strong>FREE</strong></div>
                            </div>
                            <div class="order-col">
                                <div><strong>TOTAL</strong></div>
                                @if (count($remains))
                                    <div><strong class="order-total">${{ $remains['remain'] }}</strong></div>
                                @else
                                    <div><strong class="order-total">${{ $total }}</strong></div>
                                @endif
                            </div>
                        </div>
                        <div class="payment-method">

                            <div class="input-radio">
                                <input type="radio" name="payment" id="payment-1">
                                <label for="payment-1">
                                    <span></span>
                                    Credit Card
                                </label>
                                <div class="caption">
                                    <form action="/charge" method="post" id="payment-form">

                                        <div class="form-row">

                                            <div id="card-element">

                                                <!-- a Stripe Element will be inserted here. -->

                                            </div>

                                            <!-- Used to display form errors -->

                                            <div id="card-errors"></div>

                                        </div>

                                        {{-- <input type="submit" class="submit" value="Submit Payment"> --}}

                                    </form>
                                </div>
                            </div>
                            <div class="input-radio">
                                <input type="radio" name="payment" value="CODE" id="payment-2">
                                <label for="payment-2">
                                    <span></span>
                                    Cash On Delevery
                                </label>
                                <div class="caption">
                                    <p>Pay when get your order!</p>
                                </div>
                            </div>


                            <button type="submit" class="primary-btn order-submit">Place order</a>
                        </div>
                        <!-- /Order Details -->
                    </div>
                    <!-- /row -->
                </form>
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->

        <!-- /NEWSLETTER -->
    @endsection

    