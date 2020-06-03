<div class="container section-marginTop text-center">
    <h1 class="section-title">কোর্স সমূহ </h1>
    <h1 class="section-subtitle">আইটি কোর্স, প্রজেক্ট ভিত্তিক সোর্স কোড সহ আরো যে সকল সার্ভিস আমরা প্রদান করি </h1>
    <div class="row">
        @foreach($CourseData as $CourseData)
        <div class="col-md-4 thumbnail-container">
                <img src="{{$CourseData->course_img}}" alt="Avatar" class="thumbnail-image ">
                <div class="thumbnail-middle">
                    <h1 class="thumbnail-title">{{$CourseData->course_name}}</h1>
                    <h1 class="thumbnail-subtitle">{{$CourseData->course_des}}</h1>
                    <h1 class="thumbnail-subtitle">Course Fee: {{$CourseData->course_fee}}</h1>
                    <a target="_blank" href="{{$CourseData->course_link}}" class="normal-btn btn">শুরু করুন</a>
                </div>
        </div>
        @endforeach
    </div>
</div>

