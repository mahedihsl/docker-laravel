<div id="contact" class="container-padding20">
  <div class="container">
    <div class="post-heading-center">
        {{-- <p>Let’s Discussion with Us</p> --}}
        <h2>Keep in touch</h2>
    </div>
    <!-- .row -->
    <div class="row padding-bottom20">
      <div class="col-sm-4"> <!-- 1 -->
        <div class="affa-contact-info">
          <div class="contact-info-heading">
            <p>+880 1907888839</p>
            <p>+880 1907888899</p>
          </div>
          <i class="ion ion-ios-telephone-outline"></i>
          <h4>Phone Number</h4>
        </div>
      </div>
      <div class="col-sm-4"> <!-- 2 -->
        <div class="affa-contact-info">
          <div class="contact-info-heading">
            <p><a href="mailto:support@affapress.com">hs@hypersystems.com.bd</a></p>
            <p><a href="mailto:admin@affapress.com">hscare@hypersystems.com.bd</a></p>
          </div>
          <i class="ion ion-ios-email-outline"></i>
          <h4>Email Address</h4>
        </div>
      </div>
      <div class="col-sm-4"> <!-- 3 -->
        <div class="affa-contact-info">
          <div class="contact-info-heading">
            <p>Tower Hamlet (5th Floor)<br>16 Kemal Ataturk Avenue, Banani C/A</p>
          </div>
          <i class="ion ion-map"></i>
          <h4>Business Address</h4>
        </div>
      </div>
    </div>
    <!-- .row end -->
    <div class="row">
      <div class="col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
        <form action="{{route('save-message')}}" method="post" class="affa-form-contact">
          {!! csrf_field() !!}
          <div class="submit-status"></div> <!-- submit status -->
          <input type="text" name="name" placeholder="Your Name">
          <input type="text" name="phone" placeholder="Phone Number">
          <input type="text" name="email" placeholder="Email Address *">
          <textarea name="message" placeholder="Message *"></textarea>
          <div class="form-contact-submit">
            {{-- <label for="send_copy"><input type="checkbox" name="send_copy" id="send_copy"> Send a copy to my email</label> --}}
            <input type="submit" name="submit" value="Send Message" class="btn-border">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
