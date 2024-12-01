<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
        ['key'=>'app_name','value'=>'e-commerce','lang'=>'en'],
        ['key'=>'app_name','value'=>'متجر الكترونى','lang'=>'ar'],

        ['key'=>'top_text','value'=>'Any note for users','lang'=>'en'],
        ['key'=>'top_text','value'=>'لصق اشعار للمسنخدمين','lang'=>'ar'],

        ['key'=>'about_app','value'=>'...','lang'=>'en'],
        ['key'=>'about_app','value'=>'...','lang'=>'ar'],

        ['key'=>'address1','value'=>'...','lang'=>'en'],
        ['key'=>'address1','value'=>'...','lang'=>'ar'],

        ['key'=>'address2','value'=>'...','lang'=>'en'],
        ['key'=>'address2','value'=>'...','lang'=>'ar'],

        ['key'=>'logo','value'=>'shipping.png','lang'=>'en'],
        ['key'=>'logo_footer','value'=>'shipping.png','lang'=>'en'],
        ['key'=>'favicon','value'=>'shipping.png','lang'=>'en'],
        ['key'=>'inspection_image','value'=>'shipping.png','lang'=>'en'],

        ['key'=>'logo','value'=>'shipping.png','lang'=>'ar'],
        ['key'=>'logo_footer','value'=>'shipping.png','lang'=>'ar'],
        ['key'=>'favicon','value'=>'shipping.png','lang'=>'ar'],
        ['key'=>'inspection_image','value'=>'shipping.png','lang'=>'ar'],

        ['key'=>'lang','value'=>'lang','lang'=>'all'],

        ['key'=>'email','value'=>'e-commerce@gmail.com','lang'=>'all'],
        ['key'=>'contact_email','value'=>'e-commerce@gmail.net','lang'=>'all'],
        ['key'=>'telephone','value'=>'123456789','lang'=>'all'],
        ['key'=>'mobile','value'=>'234567891','lang'=>'all'],
        ['key'=>'fax','value'=>'345678912','lang'=>'all'],
        ['key'=>'whatsapp','value'=>'456789123','lang'=>'all'],
        ['key'=>'snapchat','value'=>'https://www.snapchat.com/','lang'=>'all'],
        ['key'=>'facebook','value'=>'https://www.facebook.com/','lang'=>'all'],
        ['key'=>'linkedin','value'=>'https://www.linkedin.com/','lang'=>'all'],
        ['key'=>'youtube','value'=>'https://www.youtube.com/','lang'=>'all'],
        ['key'=>'instgram','value'=>'https://www.instagram.com/','lang'=>'all'],
        ['key'=>'twitter','value'=>'https://twitter.com/?lang=ar','lang'=>'all'],
        ['key'=>'map_url','value'=>'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d431.5679492896066!2d31.338111658194997!3d30.078614422345606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583e1826e40b7d%3A0x31cbb8966fc8302c!2z2KfYs9mF2KfYoSDZgdmH2YXZitiMINin2YTYrNmI2YTZgdiMINmF2K_ZitmG2Kkg2YbYtdix2Iwg2YXYrdin2YHYuNipINin2YTZgtin2YfYsdip4oCs!5e0!3m2!1sar!2seg!4v1733053093500!5m2!1sar!2seg','lang'=>'all'],
        ['key'=>'place_order_message','value'=>'شكرا لك على الشراء','lang'=>'ar'],
        ['key'=>'place_order_message','value'=>'Thank you for your purchase','lang'=>'en'],
        ['key'=>'shipping_fees','value'=>'0','lang'=>'all'],
        ['key'=>'shipping_type','value'=>'0','lang'=>'all'],
        ['key'=>'prefix','value'=>'e-co','lang'=>'all'],
       ];

       Setting::insert($data);
    }
}
