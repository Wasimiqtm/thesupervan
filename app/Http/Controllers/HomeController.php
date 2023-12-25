<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Email;
use App\Models\Newsletter_subscriber;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Categories;
use App\Models\ProductView;
use App\Models\Promotion;
use Hashids;
use Minioak\MyHermes\MyHermes;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $class  = 'style1';
        $class  = 'background';
        $page   = 'home';
        // $footer = 'style2';
        $footer = '';

        $products           = Product::inRandomOrder()->where(['product_id' => 0])->orderBy('id', 'desc')->limit(12)->get();
        $mostViewdProducts  = Product::inRandomOrder()->with(['product_images'])->where(['product_id' => 0,'is_hot'=>'1'])->orderBy('id','desc')->limit(12)->get();
        $promotion          = Promotion::with('products')->where('start_time','<=',now())->orderBy('start_time','asc')->first();
        $brands             = Brand::pluck('image');
        $allCategories      = Categories::with(['subcategories'])->orderBy('ordering','asc')->get();

        return view('home', compact('products','class', 'page', 'footer','promotion', 'brands', 'mostViewdProducts', 'allCategories'));
    }

    public function get_home_products(Request $request)
    {
        $param = $request->param;

        if($param == 'all') {
            $products = Product::inRandomOrder()->with(['category_products.category', 'store_products', 'isFavorite'])->where(['product_id' => 0])->orderBy('id','desc')->limit(12)->get();
        } elseif($param == 'new') {
            $products = Product::inRandomOrder()->with(['category_products.category', 'store_products', 'isFavorite'])->where(['product_id' => 0,'new_arrivals'=>'1'])->orderBy('id','desc')->limit(12)->get();
        } elseif($param == 'featured') {
            $products = Product::inRandomOrder()->with(['category_products.category', 'store_products', 'isFavorite'])->where(['product_id' => 0,'is_featured'=>'1'])->orderBy('id','desc')->limit(12)->get();
        } else {
            $products = Product::inRandomOrder()->with(['category_products.category', 'store_products', 'isFavorite'])->where(['product_id' => 0,'is_hot'=>'1'])->orderBy('id','desc')->limit(12)->get();
        }
        return view('partial_home_products', compact('products','param'));
    }

    function getCategoriesRecursive($all_categories, &$categories, $parent_id = 0, $depth = 0)
    {
        $cats = $all_categories->filter(function ($item) use ($parent_id) {
            return $item->parent_id == $parent_id;
        });

        foreach ($cats as $key => $cat)
        {
                $categories[$key] = array(
                  "id" => $cat->id,
                  "text" => str_repeat('-', $depth) .' '. $cat->name,
                );

            $this->getCategoriesRecursive($all_categories, $categories, $cat->id, $depth + 1);
        }
    }

    public function test(){
        /*$user = User::whereEmail('wasim.iqtm@gmail.com')->first();
        $newsletter_user = Newsletter_subscriber::whereEmail('wasim.iqtm@gmail.com')->first();
        $user->delete();
        $newsletter_user->delete();

        echo "done";exit;*/


        $data = [
            'email_from' => 'info@aqsinternational.com',
            'email_to' => 'wasim.iqtm@gmail.com',
            'email_subject' => 'Newsletter Subscription',
            'user_name' => 'User',
            'url' => url('unsubscribe-newsletter?id='.Hashids::encode(1)),
            'final_content' => '<p>Dear {name}</p>
                                <p>Here is your unsubscription Link {url}</p>',
        ];
        Email::sendEmail($data);
        dd('done');
    }

    public function createParcel($user)
    {
        try {
            $hermes = new MyHermes('03becf7c-638f-4bae-9496-8c7070d119d4',false);
            $address =explode(' ',$user['address']);

            $mockData = [
                'firstName' =>  $user['first_name'],
                'lastName' => $user['last_name'],
                'weight' => '2',
                'description' => 'My Test Delivery Item',
                'email' => $user['email_address'],
                'postcode' => $user['post_code'],
                'addressLine1' => trim($address[0]??'')??'',
                'addressLine2' =>  trim($address[1]??'')??'',
                'addressLine3' => $user['state_country'],
                'addressLine4' => $user['country'],
                'value' => '120'

            ];


            $response = $hermes->parcels([$mockData]);

           // $response = $service->parcels([$mockData]);
            $barcode = '';
            $image = '';
            foreach ($response as $parcel) {
                $barcode = $parcel->barcode;
                $this->createBarcode($barcode);
            }

            $image ='uploads/harmes_labels/'.$barcode.'.png';
            return ['barcode' => $barcode,'image' => $image];
        } catch(Exception $e) {
          Log::error('MyHermes barcode error: ' .$e->getMessage());
          return ['barcode' => '','image' => ''];
        }
    }

    public function testBarcode($barcode)
    {
        $this->createBarcode($barcode);
    }

    private function createBarcode($barcode)
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.myhermes.co.uk:443/api/labels/'.$barcode.'?format=THERMAL',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer  03becf7c-638f-4bae-9496-8c7070d119d4',
                    'Accept: image/png',
                    'Cookie: visid_incap_2011121=38PCrTSYSDapZLda1Tvure/Px18AAAAAQUIPAAAAAAAQ+EiFpjXjVzi/IJQReAFv; visid_incap_1996757=M18gU66+TG+cR6KjHkUJXsLsx18AAAAAQUIPAAAAAACV1B+03A4LVY81C0MBk6gB; nlbi_2011121=LrAyG/c320B4NaStYk7KeQAAAACRm6d27xQayqyFtq0/m1a4; incap_ses_960_2011121=BUPFU9VyJDt9R+B5GJtSDZLRz18AAAAAy6dadRVkO3eG/vL5p++ssg=='
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);


          file_put_contents( public_path('uploads/harmes_labels/'.$barcode.'.png'),$response);

        } catch(Exception $e) {
          Log::error('MyHermes label error: ' .$e->getMessage());
        }

    }

    public function getAuthCode()
    {
        try {
            $hermes = new MyHermes('03becf7c-638f-4bae-9496-8c7070d119d4',false);

            $mockData = [
                'firstName' => 'John',
                'lastName' => 'Mitchell',
                'weight' => '2',
                'description' => 'My Test Delivery Item',
                'email' => 'john@email.com',
                'postcode' => 'PH15HJ',
                'addressLine1' => '10 Dowling Street'

            ];


            $response = $hermes->parcels([$mockData]);


            // $response = $service->parcels([$mockData]);
            $barcode = '';
            $image = '';
            foreach ($response as $parcel) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.myhermes.co.uk:443/api/labels/'.$parcel->barcode.'?format=THERMAL',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer  03becf7c-638f-4bae-9496-8c7070d119d4',
                        'Accept: image/png',
                        'Cookie: visid_incap_2011121=38PCrTSYSDapZLda1Tvure/Px18AAAAAQUIPAAAAAAAQ+EiFpjXjVzi/IJQReAFv; visid_incap_1996757=M18gU66+TG+cR6KjHkUJXsLsx18AAAAAQUIPAAAAAACV1B+03A4LVY81C0MBk6gB; nlbi_2011121=LrAyG/c320B4NaStYk7KeQAAAACRm6d27xQayqyFtq0/m1a4; incap_ses_960_2011121=BUPFU9VyJDt9R+B5GJtSDZLRz18AAAAAy6dadRVkO3eG/vL5p++ssg=='
                    ),
                ));

                $response = curl_exec($curl);


                curl_close($curl);
                $barcode = $parcel->barcode;

                file_put_contents( public_path('uploads/harmes_labels/'.$parcel->barcode.'.png'),$response);


        }

        } catch(Exception $e) {
          Log::error('MyHermes barcode error: ' .$e->getMessage());
        }
    }
}
