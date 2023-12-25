<div class="header-middle">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div id="logo" class="logo">
                    <a href="{{ url('/') }}" title="{{ settingValue('site_title') }}">
                        <img src="{{asset('uploads/settings/site_logo.jpg')}}" alt="{{ settingValue('site_title') }}">
                    </a>
                </div><!-- /#logo -->
            </div><!-- /.col-md-3 -->
            <div class="col-md-6">
                <div class="top-search">
                    <form class="form-search">
                        <div class="cat-wrap">
                            <select name="category_id" id="searchCategory">
                                {{--@if(Request::get('category_id')>0)
                                    <option hidden value="{{ Request::get('category_id') }}">{{ getCategoryNameById(Request::get('category_id')) }}</option>
                                @else
                                    <option hidden value="">All Category</option>
                                @endif--}}
                                <option>All Category</option>
                            </select>
                            <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>

                            <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                        </div><!-- /.cat-wrap -->
                    </form>
                    <form action="{{ url('products') }}" method="get" class="form-search" accept-charset="utf-8">
                        <input type="hidden" name="category" value="all" class="records">
                        <input type="hidden" name="records" value="10" class="records">
                        <input type="hidden" name="order" value="desc">
                        <input type="hidden" name="page" value="1">
                        <input type="hidden" name="filter" value="true">
                        <input type="hidden" name="view-type" value="grid">
                        <div class="box-search">
                            <input type="text" class="setCatName" name="search" value="{{ @Request::get('search') }}" placeholder="Search what you looking for ?" autocomplete="off">
                            <span class="btn-search">
                                <button type="submit" class="waves-effect"><img src="{{asset('front_assets/images/icons/search.png')}}" alt=""></button>
                            </span>
                        </div><!-- /.box-search -->
                    </form><!-- /.form-search -->
                </div><!-- /.top-search -->
            </div><!-- /.col-md-6 -->

        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.header-middle -->
