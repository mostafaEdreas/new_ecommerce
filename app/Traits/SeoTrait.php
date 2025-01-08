<?php
namespace App\Traits;
use App\Models\SeoAssistant;
use App\Models\Setting;
use App\Models\Configration;
use Melbahja\Seo\Schema;
use Melbahja\Seo\Schema\Thing;
use Melbahja\Seo\MetaTags;
use App\Models\About;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\Page;
use App\Models\Category;
use App\Models\Brand;
use DateTime;
use App\Models\BlogItem;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait SeoTrait {


    public function ISoDateTimeFormate($date){
        $datetime = new DateTime($date);
        return $datetime->format(DateTime::ATOM).'Z'; // Updated ISO8601
    }

    ////////home page/////
    public function homePageSeo(){
        $lang =LaravelLocalization::getCurrentLocale();
        $seo = SeoAssistant::first();

        if(!$seo){
            $seo =  SeoAssistant::create([]);
        }

        $schema1 = new Thing('LocalBusiness', [
            'name'          => config('site_app_name'),
            'url'          => LaravelLocalization::localizeUrl('/'),
            'image'         => url("uploads/settings/source/".config('site_logo'))?url("uploads/settings/source/".config('site_logo')):'no logo available',
            'telephone' => config('site_mobile'),
            'address' => config('site_address1') ?? 'no address found !',
        ]);


        $schema2= new Thing('Organization', [
            'url'          => LaravelLocalization::localizeUrl('/'),
            'logo'         => url("uploads/settings/source/".config('site_logo'))?url("uploads/settings/source/".config('site_logo')):'no logo available',
            'contactPoint' => new Thing('ContactPoint', [
                'telephone' => config('site_mobile'),
                'contactType' => 'customer service'
            ]),
        ]);

        $schema = new Schema(
            $schema1,
            $schema2
        );

        $metatags = new MetaTags();
        $metatags
                ->title(($seo->home_meta_title || $seo->home_meta_title_ar)? (($lang == 'en')?$seo->home_meta_title:$seo->home_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->home_meta_title || $seo->home_meta_title_ar)? (($lang == 'en')?$seo->home_meta_title:$seo->home_meta_title_ar):config('site_app_name'))
                ->description(($seo->home_meta_desc || $seo->home_meta_desc_ar)?(($lang == 'en')?$seo->home_meta_desc:$seo->home_meta_desc_ar) :strip_tags(config('site_about_app')))
                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::localizeUrl('/'))
                ->canonical(LaravelLocalization::localizeUrl('/'))
                ->shortlink(LaravelLocalization::localizeUrl('/'))
                ->meta('robots',($seo->home_index)?'index':'noindex');

        return [$schema,$metatags];
    }

    public function aboutUsPageSeo(){
        $about = About::first();
        $lang=LaravelLocalization::getCurrentLocale();

        $seo = SeoAssistant::first();

        $metatags = new MetaTags();
        $metatags
                ->title(($seo->about_meta_title || $seo->about_meta_title_ar)? (($lang == 'en')?$seo->about_meta_title:$seo->about_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->about_meta_title || $seo->about_meta_title_ar)? (($lang == 'en')?$seo->about_meta_title:$seo->about_meta_title_ar):config('site_app_name'))
                ->description(($seo->about_meta_desc || $seo->about_meta_desc_ar)?(($lang == 'en')?$seo->about_meta_desc:$seo->about_meta_desc_ar) :strip_tags(config('site_about_app')))
                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::localizeUrl('/about-us'))
                ->canonical(LaravelLocalization::localizeUrl('/about-us'))
                ->shortlink(LaravelLocalization::localizeUrl('/about-us'))
                ->meta('robots',($seo->about_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/about-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> (($seo->about_meta_title || $seo->about_meta_title_ar)? (($lang == 'en')?$seo->about_meta_title:$seo->about_meta_title_ar):config('site_app_name')),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/about-us"),
                ]),

                'datePublished'=> $this->ISoDateTimeFormate($about->created_at),
                'dateModified'=> $this->ISoDateTimeFormate($about->updated_at),
            ])
        );
        return [$schema,$metatags];
    }

    public function contactUsPageSeo(){
        $lang=LaravelLocalization::getCurrentLocale();

        $seo = SeoAssistant::first();
        $metatags = new MetaTags();

        $metatags
                ->title(($seo->contact_meta_title || $seo->contact_meta_title_ar)? (($lang == 'en')?$seo->contact_meta_title:$seo->contact_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->contact_meta_title || $seo->contact_meta_title_ar)? (($lang == 'en')?$seo->contact_meta_title:$seo->contact_meta_title_ar):config('site_app_name'))
                ->description(($seo->contact_meta_desc || $seo->contact_meta_desc_ar)?(($lang == 'en')?$seo->contact_meta_desc:$seo->contact_meta_desc_ar) :strip_tags(config('site_about_app')))

                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::localizeUrl('/contact-us'))
                ->canonical(LaravelLocalization::localizeUrl('/contact-us'))
                ->shortlink(LaravelLocalization::localizeUrl('/contact-us'))
                ->meta('robots',($seo->contact_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/contact-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> (($seo->contact_meta_title || $seo->contact_meta_title_ar)? (($lang == 'en')?$seo->contact_meta_title:$seo->contact_meta_title_ar):config('site_app_name')),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/contact-us"),
                ]),
            ])
        );
        return [$schema,$metatags];
    }

    public function dealsPageSeo(){
        $lang=LaravelLocalization::getCurrentLocale();

        $seo = SeoAssistant::first();
        $metatags = new MetaTags();

        $metatags
                ->title(($seo->dealsProducts_meta_title || $seo->dealsProducts_meta_title_ar)? (($lang == 'en')?$seo->dealsProducts_meta_title:$seo->dealsProducts_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->dealsProducts_meta_title || $seo->dealsProducts_meta_title_ar)? (($lang == 'en')?$seo->dealsProducts_meta_title:$seo->dealsProducts_meta_title_ar):config('site_app_name'))
                ->description(($seo->dealsProducts_meta_desc || $seo->dealsProducts_meta_desc_ar)?(($lang == 'en')?$seo->dealsProducts_meta_desc:$seo->dealsProducts_meta_desc_ar) :strip_tags(config('site_about_app')))
                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
                ->canonical(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
                ->shortlink(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
                ->meta('robots',($seo->dealsProducts_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/deals"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> ($seo->dealsProducts_meta_title)?$seo->dealsProducts_meta_title:config('site_app_name'),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/deals"),
                ]),
            ])
        );
        return [$schema,$metatags];
    }



    public function productPageSeo($id){
        $lang=LaravelLocalization::getCurrentLocale();
        $product=Product::find($id);
        $seo = SeoAssistant::first();
        $rateCount=ProductReview::where('product_id',$id)->count();
        $productRate=ProductReview::where('product_id',$id)->avg('rate');

        if($rateCount > 0){
            $schema1 = new Thing('Product', [
                'name'=>($lang == 'en')?$product->name_en:$product->name_ar,
                'description'=>($product->short_desc_ar)?(($lang == 'en')?$product->short_desc_en:$product->short_desc_ar):'no description found',
                'sku'=>($product->sku_code)?$product->sku_code:'not available',
                'url'=> ($lang == 'en')?LaravelLocalization::localizeUrl("product/$product->link_en"):LaravelLocalization::localizeUrl("product/$product->link_ar"),
                'image'=> url("uploads/settings/source/".config('site_logo')),

                'aggregateRating' => new Thing('AggregateRating', [
                    'ratingValue'=>$productRate,
                    'reviewCount'=>$rateCount,
                ]),

                'brand' => new Thing('brand', [
                    'name'=>($lang == 'en')?$product->brand?->name_en:$product->brand?->name_ar,
                ]),

                'offers' => new Thing('Offer', [
                    'priceCurrency'=>'EGP',
                    'price'=>$product->price,
                    'itemCondition'=>'NewCondition',
                    'availability'=>($product->quantity > 0)?'InStock':'OutOfStock',

                    'seller' => new Thing('Organization', [
                        'name'=>'Naguib Selim',
                    ]),

                ]),

            ]);
        }else{
            $schema1 = new Thing('Product', [
                'name'=>($lang == 'en')?$product->name_en:$product->name_ar,
                'description'=>($product->short_desc_ar)?(($lang == 'en')?$product->short_desc_en:$product->short_desc_ar):'no description found',
                'sku'=>($product->sku_code)?$product->sku_code:'not available',
                'url'=> ($lang == 'en')?LaravelLocalization::localizeUrl("product/$product->link_en"):LaravelLocalization::localizeUrl("product/$product->link_ar"),
                'image'=> url("uploads/settings/source/".config('site_logo')),


                'brand' => new Thing('brand', [
                    'name'=>($lang == 'en')?$product->brand?->name_en:$product->brand?->name_ar,
                ]),

                'offers' => new Thing('Offer', [
                    'priceCurrency'=>'EGP',
                    'price'=>$product->price,
                    'itemCondition'=>'NewCondition',
                    'availability'=>($product->quantity > 0)?'InStock':'OutOfStock',

                    'seller' => new Thing('Organization', [
                        'name'=>'Naguib Selim',
                    ]),

                ]),
            ]);
        }


        $schema3 = new Thing('ItemPage', [
            'id'=>($lang == 'en')?LaravelLocalization::localizeUrl("product/$product->link_en"):LaravelLocalization::localizeUrl("product/$product->link_ar").'#webpage',
            'name'=>($lang == 'en')?$product->name_en:$product->name_ar,
            'url'=> ($lang == 'en')?LaravelLocalization::localizeUrl("product/$product->link_en"):LaravelLocalization::localizeUrl("product/$product->link_ar"),
            'primaryImageOfPage'=> url("uploads/settings/source/".config('site_logo')),

            'isPartOf' => new Thing('URL', [
                'id'=>LaravelLocalization::localizeUrl("/").'#website',
            ]),

            'datePublished'=> $this->ISoDateTimeFormate($product->created_at),
            'dateModified'=> $this->ISoDateTimeFormate($product->updated_at),
        ]);



        $schema = new Schema(
            $schema1,
            $schema3
        );

        $metatags = new MetaTags();
        $metatags
                ->title(($lang == 'en')?(($product->meta_title_en)?$product->meta_title_en:$product->link_en):(($product->meta_title_ar)?$product->meta_title_ar:$product->link_ar))
                ->meta('title',($lang == 'en')?(($product->meta_title_en)?$product->meta_title_en:$product->link_en):(($product->meta_title_ar)?$product->meta_title_ar:$product->link_ar))
                ->description(($lang == 'en')?(($product->meta_desc_en)?$product->meta_desc_en:$product->link_en):(($product->meta_desc_ar)?$product->meta_desc_ar:$product->link_ar))
                ->meta('author',config('site_app_name'))
                ->meta('time',date('D M j G:i:s T Y', strtotime($product->created_at)))
                ->image(($product->main_image)?url('uploads/products/source/'.$product->main_image):url('resources/assets/front/images/noimage.png'))
                ->mobile(($lang == 'en')?LaravelLocalization::localizeUrl("product/$product->link_en"):LaravelLocalization::localizeUrl("product/$product->link_ar"))
                ->canonical(($lang == 'en')?LaravelLocalization::localizeUrl("product/$product->link_en"):LaravelLocalization::localizeUrl("product/$product->link_ar"))
                ->shortlink(($lang == 'en')?LaravelLocalization::localizeUrl("product/$product->link_en"):LaravelLocalization::localizeUrl("product/$product->link_ar"))
                ->meta('robots','index');

        return [$schema,$metatags];
    }

    public function pageSeo($link){
        $lang=LaravelLocalization::getCurrentLocale();
        $page =Page::where('link_en',$link)->orwhere('link_ar',$link)->first();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();

        $metatags
            ->title(($lang == 'en')?(($page->meta_title_en)?$page->meta_title_en:$page->link_en):(($page->meta_title_ar)?$page->meta_title_ar:$page->link_ar))
            ->meta('title',($lang == 'en')?(($page->meta_title_en)?$page->meta_title_en:$page->link_en):(($page->meta_title_ar)?$page->meta_title_ar:$page->link_ar))
            ->description(($lang == 'en')?(($page->meta_desc_en)?$page->meta_desc_en:$page->link_en):(($page->meta_desc_ar)?$page->meta_desc_ar:$page->link_ar))
            ->meta('author',config('site_app_name'))
            ->meta('time',date('D M j G:i:s T Y', strtotime($page->created_at)))
            ->image(url("uploads/settings/source/".config('site_logo')))
            ->mobile(LaravelLocalization::localizeUrl("page/$link"))
            ->canonical(LaravelLocalization::localizeUrl("page/$link"))
            ->shortlink(LaravelLocalization::localizeUrl("page/$link"))
            ->meta('robots',($page->index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/bout-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> ($seo->about_meta_title)?$seo->about_meta_title:config('site_app_name'),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/bout-us"),
                ]),
            ])
        );

        return [$schema,$metatags];
    }

    public function categoryPageSeo($link){
        $lang=LaravelLocalization::getCurrentLocale();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();

        $category=Category::where('link_en',$link)->orwhere('link_ar',$link)->first();

        $metatags
            ->title(($lang == 'en')?(($category->meta_title_en)?$category->meta_title_en:$category->link_en):(($category->meta_title_ar)?$category->meta_title_ar:$category->link_ar))
            ->meta('title',($lang == 'en')?(($category->meta_title_en)?$category->meta_title_en:$category->link_en):(($category->meta_title_ar)?$category->meta_title_ar:$category->link_ar))
            ->description(($lang == 'en')?(($category->meta_desc_en)?$category->meta_desc_en:$category->link_en):(($category->meta_desc_ar)?$category->meta_desc_ar:$category->link_ar))

            ->meta('author',config('site_app_name'))
            ->meta('time',date('D M j G:i:s T Y', strtotime($category->created_at)))
            ->image(url("uploads/categories/source/$category->image"))
            ->mobile(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
            ->canonical(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
            ->shortlink(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
            ->meta('robots',($category->index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> url("/bout-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> ($seo->about_meta_title)?$seo->about_meta_title:config('site_app_name'),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/bout-us"),
                ]),
            ])
        );

        return [$schema,$metatags];
    }

    public function brandPageSeo($link){
        $lang=LaravelLocalization::getCurrentLocale();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();

        $brand=Brand::where('link_en',$link)->orwhere('link_ar',$link)->first();

        $metatags
            ->title(($lang == 'en')?(($brand->meta_title_en)?$brand->meta_title_en:$brand->link_en):(($brand->meta_title_ar)?$brand->meta_title_ar:$brand->link_ar))
            ->meta('title',($lang == 'en')?(($brand->meta_title_en)?$brand->meta_title_en:$brand->link_en):(($brand->meta_title_ar)?$brand->meta_title_ar:$brand->link_ar))
            ->description(($lang == 'en')?(($brand->meta_desc_en)?$brand->meta_desc_en:$brand->link_en):(($brand->meta_desc_ar)?$brand->meta_desc_ar:$brand->link_ar))
            ->meta('author',config('site_app_name'))
            ->meta('time',date('D M j G:i:s T Y', strtotime($brand->created_at)))
            ->image(url("uploads/brand/source/$brand->logo"))
            ->mobile(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
            ->canonical(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
            ->shortlink(LaravelLocalization::getLocalizedURL($lang, null, [], true) )
            ->meta('robots',($brand->index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> url("/bout-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> ($seo->about_meta_title)?$seo->about_meta_title:config('site_app_name'),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/bout-us"),
                ]),
            ])
        );

        return [$schema,$metatags];
    }
    public function brandsPageSeo(){
        $lang=LaravelLocalization::getCurrentLocale();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();
        $brand = Brand::first();

        $metatags
            ->title(($seo->brands_meta_title || $seo->brands_meta_title_ar)? (($lang == 'en')?$seo->brands_meta_title:$seo->brands_meta_title_ar):config('site_app_name'))
            ->meta('title',($seo->brands_meta_title || $seo->brands_meta_title_ar)? (($lang == 'en')?$seo->brands_meta_title:$seo->brands_meta_title_ar):config('site_app_name'))
            ->description(($seo->brands_meta_desc || $seo->brands_meta_desc_ar)?(($lang == 'en')?$seo->brands_meta_desc:$seo->brands_meta_desc_ar) :strip_tags(config('site_about_app')))
            ->meta('author',config('site_app_name'))
            ->image(url("uploads/settings/source/".config('site_logo')))
            ->mobile(LaravelLocalization::localizeUrl('/brands'))
            ->canonical(LaravelLocalization::localizeUrl('/brands'))
            ->shortlink(LaravelLocalization::localizeUrl('/brands'))
            ->meta('robots',($seo->brands_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/brands"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> (($seo->brands_meta_title || $seo->brands_meta_title_ar)? (($lang == 'en')?$seo->brands_meta_title:$seo->brands_meta_title_ar):config('site_app_name')),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/brands"),
                ]),

                'datePublished'=> $this->ISoDateTimeFormate($brand->created_at),
                'dateModified'=> $this->ISoDateTimeFormate($brand->updated_at),
            ])
        );
        return [$schema,$metatags];
    }

    public function blogsPageSeo(){
        $lang=LaravelLocalization::getCurrentLocale();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();
        $about = About::first();

        $metatags
                ->title(($seo->blogs_meta_title || $seo->blogs_meta_title_ar)? (($lang == 'en')?$seo->blogs_meta_title:$seo->blogs_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->blogs_meta_title || $seo->blogs_meta_title_ar)? (($lang == 'en')?$seo->blogs_meta_title:$seo->blogs_meta_title_ar):config('site_app_name'))
                ->description(($seo->blogs_meta_desc || $seo->blogs_meta_desc_ar)?(($lang == 'en')?$seo->blogs_meta_desc:$seo->blogs_meta_desc_ar) :strip_tags(config('site_about_app')))
                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::localizeUrl('/trendings'))
                ->canonical(LaravelLocalization::localizeUrl('/trendings'))
                ->shortlink(LaravelLocalization::localizeUrl('/trendings'))
                ->meta('robots',($seo->blogs_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/about-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> (($seo->about_meta_title || $seo->about_meta_title_ar)? (($lang == 'en')?$seo->about_meta_title:$seo->about_meta_title_ar):config('site_app_name')),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/about-us"),
                ]),

                'datePublished'=> $this->ISoDateTimeFormate($about->created_at),
                'dateModified'=> $this->ISoDateTimeFormate($about->updated_at),
            ])
        );
        return [$schema,$metatags];
    }

    public function branchesPageSeo(){
        $lang=LaravelLocalization::getCurrentLocale();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();
        $about = About::first();

        $metatags
                ->title(($seo->branches_meta_title || $seo->branches_meta_title_ar)? (($lang == 'en')?$seo->branches_meta_title:$seo->branches_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->branches_meta_title || $seo->branches_meta_title_ar)? (($lang == 'en')?$seo->branches_meta_title:$seo->branches_meta_title_ar):config('site_app_name'))
                ->description(($seo->branches_meta_desc || $seo->branches_meta_desc_ar)?(($lang == 'en')?$seo->branches_meta_desc:$seo->branches_meta_desc_ar) :strip_tags(config('site_about_app')))
                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::localizeUrl('/branches'))
                ->canonical(LaravelLocalization::localizeUrl('/branches'))
                ->shortlink(LaravelLocalization::localizeUrl('/branches'))
                ->meta('robots',($seo->branches_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/about-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> (($seo->about_meta_title || $seo->about_meta_title_ar)? (($lang == 'en')?$seo->about_meta_title:$seo->about_meta_title_ar):config('site_app_name')),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/about-us"),
                ]),

                'datePublished'=> $this->ISoDateTimeFormate($about->created_at),
                'dateModified'=> $this->ISoDateTimeFormate($about->updated_at),
            ])
        );
        return [$schema,$metatags];
    }

    public function inspectionRequestPageSeo(){
        $lang=LaravelLocalization::getCurrentLocale();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();
        $about = About::first();

        $metatags
                ->title(($seo->inspectionRequest_meta_title || $seo->inspectionRequest_meta_title_ar)? (($lang == 'en')?$seo->inspectionRequest_meta_title:$seo->inspectionRequest_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->inspectionRequest_meta_title || $seo->inspectionRequest_meta_title_ar)? (($lang == 'en')?$seo->inspectionRequest_meta_title:$seo->inspectionRequest_meta_title_ar):config('site_app_name'))
                ->description(($seo->inspectionRequest_meta_desc || $seo->inspectionRequest_meta_desc_ar)?(($lang == 'en')?$seo->inspectionRequest_meta_desc:$seo->inspectionRequest_meta_desc_ar) :strip_tags(config('site_about_app')))
                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::localizeUrl('/inspection-request'))
                ->canonical(LaravelLocalization::localizeUrl('/inspection-request'))
                ->shortlink(LaravelLocalization::localizeUrl('/inspection-request'))
                ->meta('robots',($seo->featuredProducts_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/about-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> (($seo->about_meta_title || $seo->about_meta_title_ar)? (($lang == 'en')?$seo->about_meta_title:$seo->about_meta_title_ar):config('site_app_name')),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/about-us"),
                ]),

                'datePublished'=> $this->ISoDateTimeFormate($about->created_at),
                'dateModified'=> $this->ISoDateTimeFormate($about->updated_at),
            ])
        );
        return [$schema,$metatags];
    }

    public function categoriesPageSeo(){
        $lang=LaravelLocalization::getCurrentLocale();

        $seo = SeoAssistant::first();
        $metatags = new MetaTags();
        $about = About::first();

        $metatags
                ->title(($seo->categories_meta_title || $seo->categories_meta_title_ar)? (($lang == 'en')?$seo->categories_meta_title:$seo->categories_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->categories_meta_title || $seo->categories_meta_title_ar)? (($lang == 'en')?$seo->categories_meta_title:$seo->categories_meta_title_ar):config('site_app_name'))
                ->description(($seo->categories_meta_desc || $seo->categories_meta_desc_ar)?(($lang == 'en')?$seo->categories_meta_desc:$seo->categories_meta_desc_ar) :strip_tags(config('site_about_app')))
                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::localizeUrl('/categories'))
                ->canonical(LaravelLocalization::localizeUrl('/categories'))
                ->shortlink(LaravelLocalization::localizeUrl('/categories'))
                ->meta('robots',($seo->categories_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/about-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> (($seo->about_meta_title || $seo->about_meta_title_ar)? (($lang == 'en')?$seo->about_meta_title:$seo->about_meta_title_ar):config('site_app_name')),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/about-us"),
                ]),

                'datePublished'=> $this->ISoDateTimeFormate($about->created_at),
                'dateModified'=> $this->ISoDateTimeFormate($about->updated_at),
            ])
        );
        return [$schema,$metatags];
    }
    public function productsPageSeo(){
        $lang=LaravelLocalization::getCurrentLocale();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();
        $about = About::firstOrCreate([]);

        $metatags
                ->title(($seo->featuredProducts_meta_title || $seo->featuredProducts_meta_title_ar)? (($lang == 'en')?$seo->featuredProducts_meta_title:$seo->featuredProducts_meta_title_ar):config('site_app_name'))
                ->meta('title',($seo->featuredProducts_meta_title || $seo->featuredProducts_meta_title_ar)? (($lang == 'en')?$seo->featuredProducts_meta_title:$seo->featuredProducts_meta_title_ar):config('site_app_name'))
                ->description(($seo->featuredProducts_meta || $seo->featuredProducts_meta_ar)?(($lang == 'en')?$seo->featuredProducts_meta:$seo->featuredProducts_meta_ar) :strip_tags(config('site_about_app')))
                ->meta('author',config('site_app_name'))
                ->image(url("uploads/settings/source/".config('site_logo')))
                ->mobile(LaravelLocalization::localizeUrl('/categories'))
                ->canonical(LaravelLocalization::localizeUrl('/categories'))
                ->shortlink(LaravelLocalization::localizeUrl('/categories'))
                ->meta('robots',($seo->featuredProducts_index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/about-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> (($seo->about_meta_title || $seo->about_meta_title_ar)? (($lang == 'en')?$seo->about_meta_title:$seo->about_meta_title_ar):config('site_app_name')),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/about-us"),
                ]),

                'datePublished'=> $this->ISoDateTimeFormate($about->created_at),
                'dateModified'=> $this->ISoDateTimeFormate($about->updated_at),
            ])
        );
        return [$schema,$metatags];
    }

    public function blogPageSeo($link){
        $lang=LaravelLocalization::getCurrentLocale();
        $blog =BlogItem::where('link_en',$link)->orwhere('link_ar',$link)->first();
        $seo = SeoAssistant::first();
        $metatags = new MetaTags();

        $metatags
            ->title(($lang == 'en')?(($blog->meta_title_en)?$blog->meta_title_en:$blog->link_en):(($blog->meta_title_ar)?$blog->meta_title_ar:$blog->link_ar))
            ->meta('title',($lang == 'en')?(($blog->meta_title_en)?$blog->meta_title_en:$blog->link_en):(($blog->meta_title_ar)?$blog->meta_title_ar:$blog->link_ar))
            ->description(($lang == 'en')?(($blog->meta_desc_en)?$blog->meta_desc_en:$blog->link_en):(($blog->meta_desc_ar)?$blog->meta_desc_ar:$blog->link_ar))
            ->meta('author',config('site_app_name'))
            ->meta('time',date('D M j G:i:s T Y', strtotime($blog->created_at)))
            ->image(url("uploads/settings/source/".config('site_logo')))
            ->mobile(LaravelLocalization::localizeUrl("trending/$link"))
            ->canonical(LaravelLocalization::localizeUrl("trending/$link"))
            ->shortlink(LaravelLocalization::localizeUrl("trending/$link"))
            ->meta('robots',($blog->index)?'index':'noindex');

        $schema = new Schema(
            new Thing('Article', [
                'url'=> LaravelLocalization::localizeUrl("/bout-us"),
                'image'=> url("uploads/settings/source/".config('site_logo')),
                'headline'=> ($seo->about_meta_title)?$seo->about_meta_title:config('site_app_name'),
                'author' => new Thing('author', [
                    'name'=>config('site_app_name'),
                    'url'=> LaravelLocalization::localizeUrl("/bout-us"),
                ]),
            ])
        );

        return [$schema,$metatags];
    }


}
