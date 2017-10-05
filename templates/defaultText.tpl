<div class="row">
  <div class="col">
    {$nodeText}
    <div id="enquiry-container">
      <p>Does this sound like your particular issue?</p>
      <p>If so, enter your name, email address and phone number below to make contact with us</p>
      <form action="/" id="enquiry-form" method="GET">
        <label>First name: <input type="text" name="first_name" value="" placeholder="First name"></label>
        <label>Email: <input type="text" name="email" value="" placeholder="Email"></label>
        <label>Phone number: <input type="text" name="phone" value="" placeholder="Phone number"></label>
        <label>Message: </label>
        <textarea name="message"></textarea>
        <div class="g-recaptcha" data-sitekey="6LeREBQUAAAAABj5Bj1RmM2PAIkVLD1UWA2f6TNN" data-callback="captchaSubmitted"></div>
        <input type="submit" style="display:none;">
      </form>
    </div>

  </div>
</div>
