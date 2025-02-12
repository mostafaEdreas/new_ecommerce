@extends('layouts.app')
@section('meta')
    <title>{{trans('home.search_results')}}</title>
@endsection
@section('content')
    <!-- rts navigation bar area start -->
    <div class="rts-navigation-area-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigator-breadcrumb-wrapper">
                        <a href="{{LaravelLocalization::localizeUrl('/')}}">{{__('home.home')}}</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="javascript:void">@lang('home.terms & condation')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts navigation bar area end -->
    <div class="section-seperator">
        <div class="container">
            <hr class="section-seperator">
        </div>
    </div>


    <!-- Terms & Condition area start -->
    <div class="rts-pricavy-policy-area rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container-privacy-policy">
                        <h2 class="title mb--40">الشروط والأحكام</h2>
                        <p class="disc">
                            من الحقائق الثابتة منذ فترة طويلة أن القارئ سوف يصرف انتباهه عن المحتوى القابل للقراءة للصفحة عند النظر إلى تخطيطها. النقطة في استخدام لوريم إيبسوم هي أن لديها توزيعًا طبيعيًا إلى حد ما للحروف، على عكس استخدام "المحتوى هنا، المحتوى هنا"، مما يجعلها تبدو وكأنها لغة إنجليزية قابلة للقراءة.
                        </p>
                        <p class="disc">
                            العديد من حزم النشر المكتبي ومحرري صفحات الويب يستخدمون الآن لوريم إيبسوم كنص نموذج افتراضي، والبحث عن "لوريم إيبسوم" سيكشف عن العديد من المواقع التي لا تزال في مراحلها الأولى. تطورت العديد من الإصدارات على مر السنين، أحيانًا عن طريق الصدفة، وأحيانًا عن قصد (إدخال الفكاهة وما إلى ذلك).
                        </p>
                        <p class="disc mb--15">
                            تميل جميع مولدات لوريم إيبسوم على الإنترنت إلى تكرار القطع المحددة مسبقًا حسب الضرورة، مما يجعل هذا أول مولد حقيقي على الإنترنت. يستخدم قاموسًا يحتوي على أكثر من 200 كلمة لاتينية، إلى جانب عدد قليل من هياكل الجمل النموذجية، لإنشاء لوريم إيبسوم الذي يبدو معقولًا. لذلك فإن لوريم إيبسوم المولدة خالية دائمًا من التكرار، والفكاهة المدخلة، أو الكلمات غير المميزة.
                        </p>
                        <div class="section-list mt--40">
                            <h2 class="title">تحديد المعلومات الشخصية للمستخدمين</h2>
                            <ul>
                                <li><p>تميل جميع مولدات لوريم إيبسوم على الإنترنت إلى تكرار القطع المحددة مسبقًا حسب الضرورة، مما يجعل هذا أول مولد حقيقي على الإنترنت.</p></li>
                                <li><p>يستخدم قاموسًا يحتوي على أكثر من 200 كلمة لاتينية، إلى جانب عدد قليل من هياكل الجمل النموذجية، لإنشاء لوريم إيبسوم الذي يبدو معقولًا. لذلك فإن لوريم إيبسوم المولدة خالية دائمًا من التكرار، والفكاهة المدخلة، أو الكلمات غير المميزة.</p></li>
                                <li><p>هناك العديد من الإصدارات من مقاطع لوريم إيبسوم المتاحة، ولكن الغالبية تعرضت للتغيير في بعض الأشكال، عن طريق إدخال الفكاهة، أو الكلمات العشوائية التي لا تبدو قابلة للتصديق قليلاً.</p></li>
                            </ul>
                        </div>
                        <div class="section-list mt--40">
                            <h2 class="title">أسباب جمع ومعالجة المعلومات الشخصية للمستخدمين</h2>
                            <ul>
                                <li><p>تميل جميع مولدات لوريم إيبسوم على الإنترنت إلى تكرار القطع المحددة مسبقًا حسب الضرورة، مما يجعل هذا أول مولد حقيقي على الإنترنت.</p></li>
                                <li><p>يستخدم قاموسًا يحتوي على أكثر من 200 كلمة لاتينية، إلى جانب عدد قليل من هياكل الجمل النموذجية، لإنشاء لوريم إيبسوم الذي يبدو معقولًا. لذلك فإن لوريم إيبسوم المولدة خالية دائمًا من التكرار، والفكاهة المدخلة، أو الكلمات غير المميزة.</p></li>
                                <li><p>هناك العديد من الإصدارات من مقاطع لوريم إيبسوم المتاحة، ولكن الغالبية تعرضت للتغيير في بعض الأشكال، عن طريق إدخال الفكاهة، أو الكلمات العشوائية التي لا تبدو قابلة للتصديق قليلاً.</p></li>
                            </ul>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Terms & Condition area end -->

@endsection
