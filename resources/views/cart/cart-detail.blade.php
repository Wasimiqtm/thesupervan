
@extends('layouts.app')

@section('content')
    <div class="container theme-container">
        <main id="main-content" class="main-container" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
            <article itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
                <header class="entry-header diblock spc-15">
                    <!-- Post Title -->
                    <h2 class="fsz-18 title-3 pull-left" itemprop="headline">Your Cart</h2>
                    <h2 class="fsz-15 title-3 drk-gry pull-right">CONTINUE SHOPPING</h2>
                </header>

                <!-- Main Content of the Post -->
                    <div id="cart_details">

                    </div>
            </article>
        </main>
    </div>


@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            getCartDetails();
            $(".remove-from-cart").click(function (e) {
                e.preventDefault();
                var ele = $(this);
                if(confirm("Are you sure you want to delete this item ?")) {
                    var id = $(this).attr('data-id');
                    show_loader();
                    $.ajax({
                        url: '{{ url('cart-remove') }}',
                        method: "DELETE",
                        data: {id: id},
                        success: function (response) {
                            if(response.status) {
                                getCartDetails();
                                success_message("Item removed from cart successfully");
                                hide_loader();


                            } else {

                                getCartDetails();
                                hide_loader();
                                toastr.error(response.message);
                            }

                        }
                    });
                }
            });
        });

        function getCartDetails(){
            $.ajax({
                url: '{{ url('cart-details') }}',
                method: "post",
                dataType: "html",
                success: function (response) {
                    if(response){
                        $('#cart_details').html(response);
                        getCartHistory();
                        // $('#cart_details').LoadingOverlay('hide');
                    }
                }
            });
        }
    </script>
@endsection
