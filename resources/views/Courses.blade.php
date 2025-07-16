@extends("layout.main-layout")
@section("content")


<main>
<div class="container-fluid bg-sec">
  <div class="row col-xxl-12  pb-0">
<h1 class="text-uppercase text-center">courses</h1>
  </div>
</div>
</main>

<section class=" mt-3 bg-founder pb-4">
<div class="container-fluid pt-3 ">
  <div class="gallery">

    <ul class="controls text-center ">
      <li class="btn active btn-warning" data-filter="all">All</li>
      <li class="btn btn-warning   m-1 " data-filter="ssc">SSC</li>
      <li class="btn btn-warning   m-1" data-filter="hsc">HSC</li>
      <li class="btn btn-warning   m-1" data-filter="11">Class 11<sup>th</sup></li>
      <li class="btn btn-warning  m-1 " data-filter="1-9">Class 1<sup>st</sup> - 9<sup>th</sup></li>
      <li class="btn btn-warning   m-1" data-filter="CC">COMPUTER </li>


    </ul>
  
    <div class="image-container flex-wrap mx-auto">
  
    

        
        <a class="course ssc all">
          <div class="card mx-auto  " style="width: 14rem;">
            <img src="img/course/1.jpg" class="card-img-top" alt="img/course/1.jpg">
            <div class="card-body">
             
              <h5 class="text-uppercase text-center fw-bold">SSC</h5>
             
              </div>
          </div>
        </a>

        <a class="course hsc">
          <div class="card mx-auto  " style="width: 14rem;">
            <img src="img/course/2.jpg" class="card-img-top" alt="img/course/2.jpg">
            <div class="card-body">
             
              <h5 class="text-uppercase text-center fw-bold">HSC</h5>
             
              </div>
          </div>
        </a>

        <a class="course 11">
          <div class="card mx-auto " style="width: 14rem;">
            <img src="img/course/3.jpg" class="card-img-top" alt="img/course/3.jpg">
            <div class="card-body">
             
              <h5 class="text-uppercase text-center fw-bold">Class 11<sup>th</sup></h5>
             
              </div>
          </div>
        </a>

        <a class="course 1-9">
          <div class="card mx-auto " style="width: 14rem;">
            <img src="img/course/4.jpg" class="card-img-top" alt="img/course/4.jpg">
            <div class="card-body">
             
              <h5 class="text-uppercase text-center fw-bold">Class 1<sup>st</sup> - 9<sup>th</sup></h5>
             
              </div>
          </div>
        </a>

        <a class="course CC">
          <div class="card mx-auto" style="width: 14rem;">
            <img src="img/course/5.jpg" class="card-img-top" alt="img/course/5.jpg">
            <div class="card-body">
             
              <h5 class="text-uppercase text-center fw-bold">COMPUTER COURSES</h5>
             
              </div>
          </div>
        </a>
		

        


  </div>
  </div>
</div>
  <!-- jquery cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- magnific popup js cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>

$(document).ready(function(){

  $('.btn').click(function(){

      $(this).addClass('active').siblings().removeClass('active');

      var filter = $(this).attr('data-filter')

      if(filter == 'all'){
          $('.course').show(400);
      }else{
          $('.course').not('.'+filter).hide(200);
          $('.course').filter('.'+filter).show(400);
      }

  });

  $('.gallery').magnificPopup({

      delegate:'a',
      type:'course',
      gallery:{
          enabled:true
      }

  });

});

</script>

  
</section>





@endsection