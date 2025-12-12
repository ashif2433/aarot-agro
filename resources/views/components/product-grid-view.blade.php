
{{-- {{ $categoryname->name; }} --}}
<?php if (!isset($classes)) {
    $classes = 'col-lg-3 col-md-3 col-sm-4 col-4';
} ?>


<div class="product {{ $classes }} pxc">
    <?php
    $typeid = $product->slug;
    ?>

    <div class="product-wrapper" style="">
        <style>
            .pxc.product:hover .details {
                transition: all 0.4s;
                padding-top: 0 !important;
            }
        </style>
        <div class="pin">
            <div class="thumbnail px-3 pt-3">
                <a href="{{ route('product.details', $product->slug) }}">
                    <img src="{{ asset('uploads/product/' . $product->image) }}" alt="Product Image">
                </a>
            </div>
            <div class="details">
                <div class="rating1" style="font-size:12px;text-align: left;">
                    @php
                        $hw = App\Models\wishlist::where('product_id', $product->id)
                            ->where('user_id', auth()->id())
                            ->first();
                        if ($hw) {
                            $color = '#54c8ec';
                        } else {
                            $color = '#a2acb5';
                        }
                        if ($product->reviews->count() > 0) {
                            $average_rating = $product->reviews->sum('rating') / $product->reviews->count();
                        } else {
                            $average_rating = 0;
                        }
                    @endphp

                </div>
                {{-- @if ($product->discount_price > 0 || $product->price)
             <!--<h6><strong style="color: var(--primary_color)">{{ setting('CURRENCY_ICON') ?? '৳' }}{{$product->price ?? $product->discount_price}}</strong> <del>{{ setting('CURRENCY_ICON') ?? '৳' }}{{$product->regular_price}}</del></h6>-->
            @else
               <h6><strong style="color: var(--primary_color)">{{ setting('CURRENCY_ICON') ?? '৳' }}{{$product->regular_price}}</strong></h6>
            @endif
                <!--<a href="{{route('product.details', $product->slug)}}">-->
                <!--    <h5>{{implode(' ', array_slice(explode(' ', $product->title), 0, 10))}}...</h5>-->
                <!--</a>--> --}}
                <a href="{{ route('product.details', $product->slug) }}">
                    <h5 class="line-clamp-2">{{ $product->title }}</h5>
                </a>


                {{-- @if ($product->discount_price > 0)
                    <span style="color: #ea6721;">

                        @if ($product->dis_type == '2')
                            @php($discount_price = round((($product->regular_price - $product->discount_price) / $product->regular_price) * 100) . '%')
                        @else
                            <?php
                            $currency_icon = setting('CURRENCY_ICON') ? setting('CURRENCY_ICON') : '৳';
                            $discount_price = $currency_icon . ($product->regular_price - $product->discount_price);
                            ?>
                        @endif
                        <h6 class="dis-label d-block">{{ $discount_price }} OFF</h6>
                        <h6></h6>
                    </span>
                @endif --}}
            </div>
            {{-- @isset($product->prdct_extra_msg)
                <h6 class="px-2 py-1" style="line-height:.9rem;font-size:.9rem;">
                    <small>{{ $product->prdct_extra_msg }}</small>
                </h6>
            @endisset --}}

            {{-- <!--<div class="quick-view"> <a href="{{ route('product.details', $product->slug) }}"><i class="icofont icofont-search"></i> Quick View</a></div>--> --}}
        </div>

        {{-- <div class="home-add2">

            <div class="cbtn bg-white d-flex" style="justify-content: center; align-items: baseline;">
                @if ($product->quantity <= '0')
                    <a href="{{ route('product.details', $product->slug) }}" class="redirect"
                        style="margin-top: 10px;background: red;color: white;border-color: red;">Pre </a>
                @else
                    @if ($product->sheba != 1)
                        <button type="submit" class="redirect" style="margin-top: 10px; width:75%"
                            data-url="{{ route('product.info', $product->slug) }}" id="productInfo" type="submit"
                            title="Add To Cart"> Add to Cart <i class="fal fa-shopping-cart" aria-hidden="true"></i>
                        </button>
                    @endif
                    <a href="{{ route('product.details', $product->slug) }}" class="btn btn-primary"
                        style="background:{{ $color }} !important; border-color:{{ $color }} !important;"><i
                            class="icofont icofont-eye"></i></a>
                @endif
                <!--<form action="{{ route('wishlist.add') }}" method="post" id="submit_payment_form{{ $typeid }}">-->
                <!--@csrf-->
                <!--    <input type="hidden" name="product_id" value="{{ $product->slug }}">-->

                <!--    <button style="margin-top: 5px;background:{{ $color }}" class="redirect" type="submit" title="Wishlist"><i class="fal fa-heart" aria-hidden="true"></i> </button>-->
                <!--</form>-->
            </div>
        </div> --}}
    </div>
</div>
@push('js')
    <script>
        // form submit
        $(document).on('submit', '#submit_payment_form{{ $typeid }}', function(e) {
            e.preventDefault();

            let action = $(this).attr('action');
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: action,
                data: formData,
                dataType: "JSON",
                beforeSend: function() {
                    loader(true);
                },
                success: function(response) {
                    responseMessage(response.alert, response.message, response.alert.toLowerCase())
                },
                complete: function() {
                    loader(false);
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        if (typeof(xhr.responseJSON.errors) !== 'undefined') {

                            $.each(xhr.responseJSON.errors, function(key, error) {
                                $('small.' + key + '').text(error);
                                $('#' + key + '').addClass('is-invalid');
                            });
                            responseMessage('Error', xhr.responseJSON.message, 'error')
                        }

                    } else if (xhr.status == 401) {
                        alert('please login');
                        window.location = '/login';

                    } else {
                        responseMessage(xhr.status, xhr.statusText, 'error')
                    }
                }
            });
        });

        // response message hande
        function responseMessage(heading, message, icon) {
            $.toast({
                heading: heading,
                text: message,
                icon: icon,
                position: 'top-right',
                stack: false
            });
        }

        // loader handle this function
        function loader(status) {
            if (status == true) {
                $('#loading-image').removeClass('d-none').addClass('d-block');

            } else {
                $('#loading-image').addClass('d-none').removeClass('d-block');
            }
        }
    </script>
@endpush
