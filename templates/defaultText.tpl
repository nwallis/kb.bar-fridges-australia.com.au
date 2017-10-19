<div class="row">
  <div class="col-11">
    <div class="jumbotron"> {$nodeText} </div>
    <div id="enquiry-container">
      <p>Does this sound like your particular issue?</p>
      <p>If so, enter your contact details and short message and we will get in touch with you.</p>
      <form action="/" id="enquiry-form" method="GET">
        <div class="form-group row">
          <label class="col-4">Name</label>
          <div class="col-8">
            <input class="form-control" type="text" name="first_name" value="" placeholder="First name">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-4">Email</label>
          <div class="col-8">
            <input type="text" class="form-control" name="email" value="" placeholder="Email">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-4">Phone number</label>
          <div class="col-8">
            <input class="form-control" type="text" name="phone" value="" placeholder="Phone number">
          </div>
        </div>
        <div class="form-group">
          <label>Tell us more</label>
          <div>
            <textarea class="form-control" name="message" rows="3"></textarea>
          </div>
        </div>
        <div class="g-recaptcha" data-sitekey="6LeREBQUAAAAABj5Bj1RmM2PAIkVLD1UWA2f6TNN" data-callback="captchaSubmitted"></div>
        <div class="form-group row">
          <button id="submit-enquiry-button" class="btn btn-primary" style="display:none;">Send message</button>
        </div>
      </form>
    </div>
  </div>
  <div class="col"></div>
</div>
